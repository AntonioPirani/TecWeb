@extends('layouts.user') 

@section('title', 'Modifica Profilo')

@section('content')
<div class="static">
    <h1>Edit Profile</h1>
    <form method="POST" action="{{ route('edituser') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="{{ Auth::user()->nome }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="cognome">Cognome</label>
            <input type="text" id="cognome" name="cognome" value="{{ Auth::user()->cognome }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ Auth::user()->username }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="new_password">Nuova Password (lascia vuoto per non modificare)</label>
            <input type="password" id="new_password" name="new_password" class="form-control">
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Conferma Nuova Password</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
        </div>

        <div class="form-group">
            <label for="dataNascita">Data di Nascita</label>
            <input type="date" id="dataNascita" name="dataNascita" value="{{ Auth::user()->dataNascita }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="occupazione">Occupazione</label>
            <select id="occupazione" name="occupazione" class="form-control">
                <option value="Studente" {{ Auth::user()->occupazione == 'Studente' ? 'selected' : '' }}>Studente</option>
                <option value="Lavoratore" {{ Auth::user()->occupazione == 'Lavoratore' ? 'selected' : '' }}>Lavoratore</option>
                <option value="Pensionato" {{ Auth::user()->occupazione == 'Pensionato' ? 'selected' : '' }}>Pensionato</option>
            </select>
        </div>


        <div class="form-group">
            <label for="indirizzo">Indirizzo</label>
            <input type="text" id="indirizzo" name="indirizzo" value="{{ Auth::user()->indirizzo }}" class="form-control">
        </div>


        <button type="submit" class="btn btn-primary">Salva Modifiche</button>
    </form>
</div>
@endsection
