@extends('technician.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/image_preview.css') }}">
    <style>
        /* Define a custom style to make the image smaller */
        .ticket-image {
            max-width: 400px; /* Ensure the image does not exceed its container width */
            height: auto; /* Maintain aspect ratio */
            max-height: 100%; /* Limit the maximum height */
        }

        .update_status {
            margin-left: 10px;
            width: 200px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ticket Details</h1>
        </div>

        <!-- Ticket Details -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $ticket->subject }}</h5>
                <form action="{{ route('technician.update-ticket-status', ['ticketId' => $ticket->id]) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Use PUT method for update -->
                    <div class="form-group">
                        <label for="status">Status</label>
                            <div class="d-flex">
                            <select class="form-control" id="status" name="status">
                                <option value="Pending" {{ $ticket->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Ongoing" {{ $ticket->status === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                <option value="Completed" {{ $ticket->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ $ticket->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-danger update_status">Update Status</button>
                        </div>
                    </div>
                </form>
                <p class="card-text"><strong>Date Posted:</strong> {{ $ticket->created_at->format('Y-m-d H:i:s') }}</p>
                <p class="card-text">{{ $ticket->message }}</p>
                @if ($ticket->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $ticket->image) }}" class="img-fluid ticket-image" alt="Ticket Image">
                    </div>
                @endif
            </div>
        </div>

        <!-- New Message Form -->
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-danger">New Message</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('technician.store-message') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Attach Image (optional)</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-danger">Send Message</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/image_preview.js') }}"></script>
@endsection
