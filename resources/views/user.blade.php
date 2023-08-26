@extends('layouts.user')

@section('title', 'Area User')

@section('content')
<div class="static">
    <h3>Area Utente</h3>
    <p>Benvenuto {{ Auth::user()->nome }} {{ Auth::user()->cognome }}</p>
    <p>Seleziona la funzione da attivare tra le scelte elencate sopra</p>
    <p>Per fare una nuova prenotazione vai al <a href={{route('auto')}}>Catalogo</a> e seleziona la macchina desiderata usando i filtri, poi clicca "Prenota" !</p>

</div>
@endsection


