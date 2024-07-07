@extends('customer.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/image_preview.css') }}">
    <style>
        /* Define a custom style to make the image smaller */
        .ticket-image {
            max-width: 400px; /* Ensure the image does not exceed its container width */
            height: auto; /* Maintain aspect ratio */
            max-height: 100%; /* Limit the maximum height */
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
                <p class="card-text"><strong>Status:</strong> {{ $ticket->status }}</p>
                <p class="card-text"><strong>Date Posted:</strong> {{ $ticket->created_at->format('Y-m-d H:i:s') }}</p>
                <p class="card-text">{{ $ticket->message }}</p>
                @if ($ticket->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $ticket->image) }}" class="img-fluid ticket-image" alt="Ticket Image">
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/image_preview.js') }}"></script>
@endsection
