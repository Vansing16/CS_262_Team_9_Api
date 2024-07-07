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
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('customer.create-ticket') }}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Create New Ticket</span>
        </a>
    </div>

    @php
        $statuses = ['Pending', 'Ongoing', 'Completed', 'Cancelled'];
    @endphp

    <!-- Display Tickets by Status -->
    @foreach($statuses as $status)
        @php
            $statusTickets = $tickets->where('status', $status);
        @endphp

        @if($statusTickets->isNotEmpty())
            <!-- Status Heading -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $status }} Tickets</h6>
                </div>
                <div class="card-body">
                    <div class="d-none d-md-flex row mx-1 mb-2">
                        <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Technician</div>
                        <div class="col-6 col-md-3 text-xs font-weight-bold text-uppercase">Subject</div>
                        <div class="col-6 col-md-3 text-xs font-weight-bold text-uppercase">Status</div>
                        <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Date Posted</div>
                        <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase text-md-center">Action</div>
                    </div>

                    @foreach($statusTickets as $ticket)
                        <div class="card shadow mb-2 status-border-{{ strtolower($ticket->status) }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-2 mb-2 mb-md-0"><strong class="d-md-none">Technician: </strong>{{ $ticket->technician ? $ticket->technician->name : 'Waiting for approval' }}</div>
                                    <div class="col-12 col-md-3 mb-2 mb-md-0"><strong class="d-md-none">Subject: </strong>{{ $ticket->subject }}</div>
                                    <div class="col-12 col-md-3 mb-2 mb-md-0">
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
                                        <strong class="d-md-none">Status: </strong>{{ $ticket->status }}
                                    </div>
                                    <div class="col-12 col-md-2 mb-2 mb-md-0"><strong class="d-md-none">Date Posted: </strong>{{ $ticket->created_at->format('d-m-Y') }}</div>
                                    <div class="col-12 col-md-2 text-md-center">
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
                    @endforeach
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
