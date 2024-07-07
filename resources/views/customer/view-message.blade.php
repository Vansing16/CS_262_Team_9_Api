@extends('customer.layout.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/image_preview.css') }}">
    <style>
        .message-thread {
            margin-top: 20px;
        }
        .message {
            display: inline-block;
            clear: both;
            margin-bottom: 10px;
            border-radius: 10px;
            padding: 10px;
            max-width: 400px; /* Adjust as needed */
            word-wrap: break-word; /* Ensure words break within the bounds */
        }
        .message-technician {
            background-color: #f1f1f1;
            float: left;
        }
        .message-customer {
            background-color: #4E73DF;
            color: white;
            float: right;
        }
        .message-header {
            font-weight: bold;
        }
        .message-body {
            margin-top: 10px;
        }
        .reply-form {
            margin-top: 20px;
        }
        .reply-form textarea {
            resize: none;
            height: 40px; /* Initial height */
            transition: height 0.3s ease; /* Smooth transition */
            min-height: 40px; /* Minimum height */
            max-height: 200px; /* Maximum height */
            overflow-y: auto; /* Enable vertical scroll if needed */
        }
        .reply-form .form-group {
            margin-top: 25px;
            margin-bottom: 10px; /* Adjust margin for form group */
        }
        .reply-form .form-group label {
            font-weight: bold; /* Bold label for image upload */
        }
        .reply-form .form-group .custom-file {
            position: relative;
            display: inline-block;
            width: auto;
            margin-bottom: 0;
        }
        .reply-form .form-group .custom-file-input {
            display: none; /* Hide the default file input */
        }
        .reply-form .form-group .file-icon {
            font-size: 1.25rem;
            color: #495057;
            cursor: pointer; /* Add cursor pointer for interaction */
            margin-top: 5px;
            transition: all 0.3s ease; /* Smooth transition for all properties */
        }
        .reply-form .form-group .file-icon:hover {
            color: #4E73DF; /* Change color on hover */
        }
        .reply-form .image-preview-container {
            position: relative;
            margin-top: 10px;
            max-width: 200px; /* Adjust maximum width */
            max-height: 200px; /* Adjust maximum height */
            overflow: hidden;
            display: none; /* Initially hide the image preview */
        }
        .reply-form .image-preview {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 5px; /* Add border radius to images */
        }
        .reply-form .cancel-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
        }
        .reply-form button {
            margin-top: 10px;
        }
        .reply-form textarea {
            resize: none;
            height: 40px; /* Initial height */
            transition: height 0.3s ease; /* Smooth transition */
            min-height: 40px; /* Minimum height */
            max-height: 200px; /* Maximum height */
            overflow-y: auto; /* Enable vertical scroll if needed */
        }
        .reply-form button {
            margin-top: 10px;
        }
        .reply-form input[type="file"] {
            margin-top: 10px;
        }
        .message-image {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            display: block;
        }
    </style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Message Details</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body d-flex flex-column"> <!-- Use flex-column to stack elements vertically -->
            <!-- Header section -->
            <div class="row mb-4">
                <!-- Display ticket details -->
                <div class="col-12 col-md-2 mb-2 mb-md-0"><strong>Technician Name: </strong>{{ $ticket->technician->name }}</div>
                <div class="col-12 col-md-3 mb-2 mb-md-0"><strong>Subject: </strong>{{ $ticket->subject }}</div>
                <div class="col-12 col-md-3 mb-2 mb-md-0"><strong>Status: </strong>{{ $ticket->status }}</div>
                <div class="col-12 col-md-2 mb-2 mb-md-0"><strong>Date Posted: </strong>{{ $ticket->created_at->format('Y-m-d') }}</div>
                <div class="col-12 col-md-2 text-md-center">
                    <a href="{{ route('customer.message') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>

            <!-- Message thread section -->
            <div class="message-thread">
                @foreach($messages as $msg)
                    <div class="message {{ $msg->sender_type === 'technician' ? 'message-technician' : 'message-customer' }}">
                        <div class="message-header">
                            <span>
                                @if($msg->sender_type === 'technician')
                                    {{ $msg->technician->name }} (Technician)
                                @else
                                    {{ $msg->customer->name }} (Customer)
                                @endif
                                ({{ $msg->created_at->format('Y-m-d H:i') }})
                            </span>
                        </div>
                        <div class="message-body">
                            {{ $msg->message }}
                            @if ($msg->image)
                                <img src="{{ asset('storage/' . $msg->image) }}" class="message-image" alt="Message Image">
                            @endif                                              
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Reply form section -->
            <div class="reply-form mt-auto"> <!-- Use 'mt-auto' to push to bottom -->
                <form action="{{ route('customer.send-message') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="form-group d-flex align-items-start">
                        <textarea name="message" id="message" rows="1" class="form-control auto-expand mr-3" placeholder="Type your message here..."></textarea>
                        <label for="image" class="file-icon ml-auto" title="Upload Image">
                            <input type="file" id="image" name="image" style="display: none;"> <!-- File input -->
                            <i class="fa fa-upload"></i> <!-- Icon for file upload -->
                        </label>
                    </div>
                    <!-- Image preview container -->
                    <div class="image-preview-container" id="image-preview-container">
                        <img id="image-preview" class="image-preview" src="#" alt="Image Preview">
                        <span id="cancel-image" class="cancel-image" title="Cancel Image"><i class="fa fa-times"></i></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/image_preview.js') }}"></script>
    <script>
        // Auto-expand textarea based on content
        document.addEventListener('input', function (event) {
            if (event.target.tagName.toLowerCase() !== 'textarea') return;
            autoExpand(event.target);
        });

        var autoExpand = function (field) {
            // Reset field height
            field.style.height = 'inherit';

            // Get the computed styles for the element
            var computed = window.getComputedStyle(field);

            // Calculate the height
            var height = parseInt(computed.getPropertyValue('border-top-width'), 10)
                         + parseInt(computed.getPropertyValue('padding-top'), 10)
                         + field.scrollHeight
                         + parseInt(computed.getPropertyValue('padding-bottom'), 10)
                         + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

            field.style.height = height + 'px';
        };

        // Image preview script
        function previewImage(input) {
            var previewContainer = document.getElementById('image-preview-container');
            var preview = document.getElementById('image-preview');
            var cancelBtn = document.getElementById('cancel-image');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block'; // Display the image preview container
                preview.style.display = 'block'; // Display the image preview
                cancelBtn.style.display = 'block'; // Display the cancel button
            };

            if (file) {
                reader.readAsDataURL(file); // Read the image file as a data URL
            } else {
                previewContainer.style.display = 'none'; // Hide the image preview container if no file selected
                preview.style.display = 'none'; // Hide the image preview if no file selected
                cancelBtn.style.display = 'none'; // Hide the cancel button if no file selected
            }
        }

        // Cancel image selection
        document.getElementById('cancel-image').addEventListener('click', function() {
            var previewContainer = document.getElementById('image-preview-container');
            var preview = document.getElementById('image-preview');
            var cancelBtn = document.getElementById('cancel-image');
            var fileInput = document.getElementById('image');

            previewContainer.style.display = 'none'; // Hide the image preview container
            preview.style.display = 'none'; // Hide the image preview
            cancelBtn.style.display = 'none'; // Hide the cancel button
            fileInput.value = ''; // Clear the file input value to allow re-selection
        });

        // Attach listener to the file input
        document.getElementById('image').addEventListener('change', function() {
            previewImage(this);
        });
    </script>
@endsection
