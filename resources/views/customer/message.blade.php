@extends('customer.layout.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Messages</h1>
    </div>
    
    <!-- Header Row -->
    <div class="d-none d-md-flex row mx-1 mb-2">
        <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Technician</div>
        <div class="col-6 col-md-6 text-xs font-weight-bold text-uppercase">Message</div>
        <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Date Posted</div>
        <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase text-md-center">Action</div>
    </div>

    @foreach($filteredMessages as $message)
        @if($message->ticket->status !== 'Completed' && $message->ticket->status !== 'Canceled')
            <div class="card shadow mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-2 mb-2 mb-md-0"><strong class="d-md-none">Technician: </strong>{{ $message->technician->name }}</div>
                        <div class="col-12 col-md-6 mb-2 mb-md-0 text-truncate">
                            <strong class="d-md-none">Message: </strong>{{ $message->message }}
                        </div>
                        <div class="col-12 col-md-2 mb-2 mb-md-0">
                            <strong class="d-md-none">Date Posted: </strong>{{ $message->created_at->format('d-m-Y') }}
                        </div>
                        <div class="col-12 col-md-2 text-md-center">
                            <strong class="d-md-none">Action: </strong>
                            <a href="{{ route('customer.view-message', ['messageId' => $message->id]) }}"><i class="bi bi-chat-left-text" style="color:blue"></i></a>
                            <a href="#"><i class="bi bi-trash" style="color:red"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
@stop

<style>
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
