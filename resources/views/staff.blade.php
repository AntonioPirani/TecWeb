@extends('layouts.staff')

@section('title', 'Area Staff')

@section('content')
<div class="static">
    <h3>Area Staff</h3>
    <p>Benvenuto {{ Auth::user()->nome }} {{ Auth::user()->cognome }}</p>
    <p>Seleziona la funzione da attivare</p>

    <div class="row">
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
    </div>
</div>
@endsection


