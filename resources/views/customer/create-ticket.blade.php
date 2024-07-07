@extends('customer.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/image_preview.css') }}">
    <style>
        /* Additional styles for form layout */
        .card-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .preview-container {
            margin-top: 20px;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Ticket</h1>
    </div>
    <div class="row">
        <div class="col">
            <div class="card mt-2 mb-3">
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.store-ticket') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter message" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Choose Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

            <div class="ps-4 mr-4 mb-4">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-danger btn-back">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/image_preview.js') }}"></script>
@endsection
