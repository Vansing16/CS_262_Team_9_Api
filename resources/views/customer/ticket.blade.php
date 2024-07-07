@extends('customer.layout.master')

@section('content')

    <div class="container-fluid">
        <!-- Alert for success messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tickets</h1>
            <a href="{{ route('customer.create-ticket') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Create New Ticket</span>
            </a>
        </div>

        <!-- Header Row -->
        <div class="d-none d-md-flex row mx-1 mb-2 align-items-center">
            <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Technician</div>
            <div class="col-6 col-md-3 text-xs font-weight-bold text-uppercase">Subject</div>
            <div class="col-6 col-md-3 text-xs font-weight-bold text-uppercase">Status</div>
            <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Date Posted</div>
            <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase text-md-center">Action</div>
        </div>

        <!-- Display Tickets -->
        @foreach($tickets as $ticket)
            @if(!$ticket->feedback_rate) <!-- Check if ticket has no feedback_rate -->
                <div class="card shadow mb-2 status-border-{{ strtolower($ticket->status) }}" style="min-height: 75px">
                    <div class="card-body d-flex align-items-center">
                        <div class="row w-100 align-items-center">
                            <div class="col-6 col-md-2 mb-2 mb-md-0 d-flex align-items-center">
                                <strong class="d-md-none">Technician: </strong>
                                <span>{{ $ticket->technician ? $ticket->technician->name : 'Waiting for approval' }}</span>
                            </div>
                            <div class="col-6 col-md-3 mb-2 mb-md-0 d-flex align-items-center">
                                <strong class="d-md-none">Subject: </strong>
                                <span>{{ $ticket->subject }}</span>
                            </div>
                            <div class="col-6 col-md-3 mb-2 mb-md-0 d-flex align-items-center">
                                <!-- Status Indicator Circle -->
                                <div class="status-circle" style="background-color: 
                                    @switch($ticket->status)
                                        @case('Pending')
                                            #F6C23D
                                            @break
                                        @case('Ongoing')
                                            #1CC88A
                                            @break
                                        @case('Completed')
                                            #4E73DF
                                            @break
                                        @case('Cancelled')
                                            #E74A3A
                                            @break
                                        @default
                                            black
                                    @endswitch"></div>
                                <strong class="d-md-none">Status: </strong>
                                <span>{{ $ticket->status }}</span>
                            </div>
                            <div class="col-6 col-md-2 mb-2 mb-md-0 d-flex align-items-center">
                                <strong class="d-md-none">Date Posted: </strong>
                                <span>{{ $ticket->created_at->format('d-m-Y') }}</span>
                            </div>
                            <div class="col-6 col-md-2 text-md-center d-flex align-items-center justify-content-center">
                                <strong class="d-md-none">Action: </strong>
                                @if($ticket->status === 'Completed')
                                    <a href="{{ route('customer.send-feedback', ['ticketId' => $ticket->id]) }}" class="btn btn-success"><i class="bi bi-chat-text"></i> Send Feedback</a>
                                @else
                                    <a href="{{ route('customer.view-ticket', ['ticketId' => $ticket->id]) }}"><i class="bi bi-eye" style="color:blue"></i></a> 
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    </div>

@stop

@section('styles')
    <style>
        /* Style for the status indicator circle */
        .status-circle {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px; /* Adjust spacing as needed */
        }

        /* Status border styles */
        .status-border-pending {
            border-left: 5px solid #F6C23D;
        }

        .status-border-ongoing {
            border-left: 5px solid #1CC88A;
        }

        .status-border-completed {
            border-left: 5px solid #4E73DF;
        }

        .status-border-cancelled {
            border-left: 5px solid #E74A3A;
        }
    </style>
@endsection
