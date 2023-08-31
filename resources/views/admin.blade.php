@extends('layouts.admin')

@section('title', 'Area Admin')

@section('content')
<div class="static">
    <h3>Area Amministratore</h3>
    <p>Benvenuto {{ Auth::user()->nome }} {{ Auth::user()->cognome }}</p>
    <p>Seleziona la funzione da attivare</p>

    <div class="row">
        <!-- Car Management Column -->
        <!-- Car Management Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestione Auto</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('addauto') }}" title="Inserisci una nuova auto">Inserisci Auto</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('editauto') }}" title="Modifica o elimina una auto">Gestisci Auto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Staff Management Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestione Staff</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('addstaff') }}" title="Aggiungi membro dello staff">Aggiungi Staff</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('editstaff') }}" title="Gestisci membri dello staff">Gestisci Staff</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- FAQ Management Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Gestione FAQ</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('addfaq') }}" title="Aggiungi membro dello staff">Aggiungi FAQ</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('editfaq') }}" title="Gestisci membri dello staff">Gestisci FAQ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Statistics Management Column -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistiche</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('monthly-stats') }}" title="Controlla le statistiche mensili">Statistiche mensili</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
