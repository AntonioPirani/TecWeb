@extends('layouts.admin')

@section('title', 'Add Staff Member')

@section('scripts')

@parent
<script src="{{ asset('js/functions.js') }}" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('#lookupButton').on('click', function () {
            // Get the username entered by the user
            var username = $('#lookupUsername').val();

            // Make an AJAX request to fetch staff member details
            $.ajax({
                type: "GET",
                url: "{{ route('getstaffdetails') }}", // Create this route in your routes file
                data: { username: username },
                success: function (response) {
                    // Display staff member details and show the edit form
                    $('#staffDetailsSection').show();

                    // Populate the current details
                    $('#currentName').val(response.name);
                    $('#currentSurname').val(response.surname);
                    $('#currentEmail').val(response.email);

                    // Populate the fields in the edit form with staff member details
                    $('#name').val(response.name);
                    $('#surname').val(response.surname);
                    $('#email').val(response.email);
                },
                error: function (error) {
                    // Display an error message if the staff member is not found
                    $('#resultMessage').html('<div class="alert alert-danger">Staff member not found</div>');
                }
            });
        });

        // Submit the edit form via AJAX as you did before
        $('#editStaffForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('updatestaff') }}",
                data: $(this).serialize(),
                success: function (response) {
                    // Display the success message
                    $('#resultMessage').html('<div class="alert alert-success">Staff member updated successfully</div>');
                },
                error: function (error) {
                    // Display the error message
                    $('#resultMessage').html('<div class="alert alert-danger">Failed to update staff member</div>');
                }
            });
        });
    });
</script>

@endsection

@section('content')
<div class="static">
    <h3>Edit Staff Member</h3>

    <!-- Input field to enter the username for lookup -->
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="lookupUsername" class="form-control" required>
        <button id="lookupButton" class="btn btn-primary">Lookup Staff Member</button>
    </div>

    <!-- Section for displaying staff member details and new form (initially hidden) -->
    <div id="staffDetailsSection" style="display: none;">
        <h4>Staff Member Details</h4>

        <!-- Display staff member details here -->
        <div class="form-group">
            <label for="currentName">Current Name</label>
            <input type="text" id="currentName" class="form-control" disabled>
        </div>
        <div class="form-group">
            <label for="currentSurname">Current Surname</label>
            <input type="text" id="currentSurname" class="form-control" disabled>
        </div>
        <div class="form-group">
            <label for="currentEmail">Current Email</label>
            <input type="email" id="currentEmail" class="form-control" disabled>
        </div>

        <!-- New form for editing staff member details -->
        <form id="editStaffForm" method="POST" action="{{ route('updatestaff') }}">
            @csrf

            <!-- Fields to edit staff member details -->
            <div class="form-group">
                <label for="name">New Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="surname">New Surname</label>
                <input type="text" name="surname" id="surname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">New Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Staff Member</button>
        </form>
    </div>

    <div id="resultMessage" style="margin-top: 20px;"></div>
</div>

@endsection
