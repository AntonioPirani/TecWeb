@extends('layouts.admin')

@section('title', 'Aggiungi Staff')

@section('scripts')

@parent
<script src="{{ asset('js/functions.js') }}" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('#addStaffForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('storestaff') }}",
                data: $(this).serialize(),
                success: function (response) {
                    // Display the success message
                    $('#resultMessage').html('<div class="alert alert-success">Staff member added successfully</div>');
                    //alert('Staff member added successfully'); //Alert


                    // Redirect to the /admin page (optional)
                    window.location.href = "{{ route('admin') }}";
                },
                error: function (error) {
                    // Display the error message
                    $('#resultMessage').html('<div class="alert alert-danger">Failed to add staff member</div>');
                }
            });
        });
    });
</script>

@endsection

@section('content')
<div class="static">
    <h3>Aggiungi un nuovo membro dello staff</h3>

    <form id="addStaffForm" method="POST" action="{{ route('storestaff') }}">
                @csrf

        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="cognome">Cognome</label>
            <input type="text" name="cognome" id="cognome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- Add more form fields as needed -->

        <button type="submit" class="btn btn-primary">Aggiungi Membro Staff</button>
    </form>
    <div id="resultMessage" style="margin-top: 20px;"></div>
</div>

@endsection
