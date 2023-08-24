@extends('layouts.admin')

@section('title', 'Add Staff Member')

@section('content')
<div class="static">
    <h3>Add New Staff Member</h3>

    <form method="POST" action="{{ route('storestaff') }}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="username">Surname</label>
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

        <button type="submit" class="btn btn-primary">Add Staff Member</button>
    </form>
</div>
@endsection
