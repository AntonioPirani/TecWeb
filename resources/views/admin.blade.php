@extends('layouts.admin')

@section('title', 'Area Admin')

@section('content')
<div class="static">
    <h3>Area Amministratore</h3>
    <p>Benvenuto {{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
    <p>Seleziona la funzione da attivare</p>

    <!--bottoni -->
    <ul>
        <li><button><a href="{{ route('newproduct') }}" title="Inserisce nuovi prodotti">Inserisci</a></button></li>
        <li><button><a href="{{ route('admin') }}" title="Inserisce nuovi prodotti"> Modifica</a></button></li>
        <li><button><a href="{{ route('admin') }}" title="Cancella o prodotti">Cancella</a></button></li>
    </ul>
</div>
@endsection


