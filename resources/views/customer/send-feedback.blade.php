<!-- resources/views/customer/send-feedback.blade.php -->

@extends('customer.layout.master')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">Send Feedback for Ticket: {{ $ticket->subject }}</h5>
            <form id="feedbackForm" action="{{ route('customer.post-feedback', ['ticketId' => $ticket->id]) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="feedback" class="form-label">Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="3" required></textarea>
                    <div class="invalid-feedback">
                        Please provide your feedback.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <fieldset class="starability-basic">
                        <input type="radio" id="rate1" name="rating" value="1" required>
                        <label for="rate1" title="Terrible">1 star</label>
                        <input type="radio" id="rate2" name="rating" value="2">
                        <label for="rate2" title="Not good">2 stars</label>
                        <input type="radio" id="rate3" name="rating" value="3">
                        <label for="rate3" title="Average">3 stars</label>
                        <input type="radio" id="rate4" name="rating" value="4">
                        <label for="rate4" title="Very good">4 stars</label>
                        <input type="radio" id="rate5" name="rating" value="5">
                        <label for="rate5" title="Amazing">5 stars</label>
                    </fieldset>
                    <div class="invalid-feedback">
                        Please rate your experience.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Starability and form validation -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ratingFieldset = document.querySelector('.starability-basic');
        var ratingRadios = ratingFieldset.querySelectorAll('input[type="radio"]');
        
        // Handle radio button change
        ratingRadios.forEach(function(radio) {
            radio.addEventListener('change', function(event) {
                var selectedRating = event.target.value;
                console.log('Selected rating:', selectedRating);
            });
        });
    });
</script>

@stop
