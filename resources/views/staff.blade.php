@extends('layouts.staff')

@section('title', 'Area Staff')

@section('content')
<div class="static">
    <h3>Area Staff</h3>
    <p>Benvenuto {{ Auth::user()->name }} {{ Auth::user()->surname }}</p>
    <p>Seleziona la funzione da attivare</p>

    <ul>
        <li><button><a href="{{ route('newproduct') }}" title="Inserisce nuovi prodotti">Inserisci</a></button></li>
        <li><button><a href="{{ route('staff') }}" title="Inserisce nuovi prodotti"> Modifica</a></button></li>
        <li><button><a href="{{ route('staff') }}" title="Cancella o prodotti">Cancella</a></li>
    </ul>

</div>
@endsection


