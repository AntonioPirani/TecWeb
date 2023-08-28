@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('scripts')
@parent
<script src="{{ asset('js/functions.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $('#lookupButton').on('click', function () {
            // Get the FAQ ID entered by the user
            var id = $('#lookupId').val();

            // Make an AJAX request to fetch FAQ details
            $.ajax({
                type: "GET",
                url: "{{ route('getfaqdetails') }}", // Create this route in your routes file
                data: { id: id },
                success: function (response) {
                    // Display FAQ details and show the edit form
                    $('#faqDetailsSection').show();

                    // Populate the fields in the edit form with FAQ details
                    $('#domanda').val(response.domanda);
                    $('#risposta').val(response.risposta);
                    $('#id').val(id);

                    // Update the success message
                    $('#resultMessage').html('<div class="alert alert-success">FAQ found</div>');
                },
                error: function (error) {
                    // Display an error message if the FAQ is not found
                    $('#faqDetailsSection').hide(); // Hide the edit form
                    $('#resultMessage').html('<div class="alert alert-danger">FAQ not found</div>');
                }
            });
        });

        // Submit the edit form via AJAX when the form is submitted
        $('#editFaqForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('updatefaq') }}",
                data: $(this).serialize(),
                success: function (response) {
                    // Display the success message
                    $('#resultMessage').html('<div class="alert alert-success">FAQ updated successfully</div>');
                },
                error: function (error) {
                    // Display the error message
                    $('#resultMessage').html('<div class="alert alert-danger">Failed to update FAQ</div>');
                }
            });
        });

        $('#deleteFaqButton').on('click', function () {
            if (confirm("Are you sure you want to delete this FAQ?")) {
                // Get the FAQ ID from the hidden input field
                var id = $('#id').val();

                // Make an AJAX request to delete the FAQ
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('deletefaq') }}", // Create this route in your routes file
                    data: { id: id },
                    success: function (response) {
                        // Redirect to the /admin page on successful deletion
                        window.location.href = "{{ route('admin') }}";
                    },
                    error: function (error) {
                        // Display an error message
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to delete FAQ</div>');
                    }
                });
            }
        });
    });

</script>

@endsection

@section('content')
<div class="static">
    <h3>Edit FAQ</h3>

    <!-- Input field to enter the FAQ ID for lookup -->
    <div class="form-group">
        <label for="id">FAQ ID</label>
        <input type="text" id="lookupId" class="form-control" required>
        <button id="lookupButton" class="btn btn-primary">Search FAQ</button>
    </div>

    <!-- Section for displaying FAQ details and edit form (initially hidden) -->
    <div id="faqDetailsSection" style="display: none;">
        <h4>FAQ Details</h4>

        <!-- New form for editing FAQ details -->
        <form id="editFaqForm" method="POST" action="{{ route('updatefaq') }}">
            @csrf

            <!-- Hidden input field for the FAQ ID -->
            <input type="hidden" name="id" id="id">

            <!-- Fields to edit FAQ details -->
            <div class="form-group">
                <label for="domanda">Domanda</label>
                <input type="text" name="domanda" id="domanda" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="risposta">Risposta</label>
                <textarea name="risposta" id="risposta" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update FAQ</button>

            <button type="button" id="deleteFaqButton" class="btn btn-danger">Delete FAQ</button>

        </form>
    </div>

    <div id="resultMessage" style="margin-top: 20px;"></div>
</div>

@endsection
