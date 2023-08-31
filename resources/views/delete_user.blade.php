@extends('layouts.admin')

@section('title', 'Elimina Utente')

@section('content')
    <div class="static">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3>Elimina Utente Registrato</h3>

                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('delete-user') }}">
                            @csrf
                            @method('DELETE')

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-danger">Delete User</button>
                        </form>
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
