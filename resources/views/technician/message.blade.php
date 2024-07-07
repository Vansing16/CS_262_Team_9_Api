@extends('technician.layout.master')

@section('content')

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Messages</h1>
        </div>
        
        <!-- Header Row -->
        <div class="d-none d-md-flex row mx-1 mb-2">
            <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Customer</div>
            <div class="col-6 col-md-6 text-xs font-weight-bold text-uppercase">Message</div>
            <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase">Date Posted</div>
            <div class="col-6 col-md-2 text-xs font-weight-bold text-uppercase text-md-center">Action</div>
        </div>

        @php
            // Filter messages to get only the latest message for each ticket_id
            $filteredMessages = $messages->sortByDesc('created_at')->unique('ticket_id');
        @endphp

        @foreach($filteredMessages as $message)
            <div class="card shadow mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-2 mb-2 mb-md-0"><strong class="d-md-none">Customer: </strong>{{ $message->customer->name }}</div>
                        <div class="col-12 col-md-6 mb-2 mb-md-0 text-truncate"><strong class="d-md-none">Message: </strong>{{ $message->message }}</div>
                        <div class="col-12 col-md-2 mb-2 mb-md-0"><strong class="d-md-none">Date Posted: </strong>{{ $message->created_at->format('d-m-Y') }}</div>
                        <div class="col-12 col-md-2 text-md-center">
                            <strong class="d-md-none">Action: </strong>
                            <a href="{{ route('technician.view-message', ['messageId' => $message->id]) }}"><i class="bi bi-chat-left-text" style="color: blue"></i></a>
                            <a href="#" class="delete-message" data-message-id="{{ $message->id }}"><i class="bi bi-trash" style="color: red"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop

@section('scripts')
    <script>
        // JavaScript for handling message deletion
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-message');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const messageId = this.getAttribute('data-message-id');

                    if (confirm('Are you sure you want to delete this message?')) {
                        // Send an AJAX request to delete the message
                        axios.delete(`/technician/messages/${messageId}`)
                            .then(response => {
                                // Optionally, update the UI or show a success message
                                console.log('Message deleted successfully');
                                // Reload the page or update the message list as needed
                                location.reload(); // Example: Reload the page
                            })
                            .catch(error => {
                                console.error('Error deleting message:', error);
                                // Handle error, show user a message, etc.
                            });
                    }
                });
            });
        });
    </script>
@stop
