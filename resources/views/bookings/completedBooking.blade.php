
@extends('layouts.user')
@section('title','Prenotazione completata')
@section('content')
    <div class="static">

        <h1>La tua prenotazione è stata completata!</h1>
        <p>Ecco i dettagli della tua prenotazione:</p>


        <ul>
            <li><strong>ID prenotazione:</strong> {{ $prenotazione->id }}</li>
            @php
                $controller = new \App\Http\Controllers\UserController();
                    $utente = $controller->getUtentefromID($prenotazione->userId);
                    $auto = $controller->getAutofromTarga($prenotazione->autoTarga);
            @endphp
            <li><strong>Prenotazione effettuata da:</strong> {{ $utente->nome }}  {{$utente->cognome}} </li>
            <li><strong>Inizio prenotazione:</strong> {{ $prenotazione->dataInizio }}</li>
            <li><strong>Fine prenotazione:</strong> {{ $prenotazione->dataFine }}</li>
            <li><strong>Targa della tua auto:</strong> {{ $prenotazione->autoTarga }}</li>
            {{--            <li><strong></strong></li>--}}
            <div class="prod">
                <div
                    class="image">@include('helpers/productImg', ['attrs' => 'imagefrm', 'imgFile' => $auto->foto])</div>

            </div>

        </ul>

        <p>Grazie per aver prenotato da noi!</p>


        <ul>
            <button id="button"><a href="{{route('auto')}}" class="highlight"
                                   title="Torna al catalogo auto">Catalogo</a></button>
            {{--  altra azione:<button id="button"><a href="{{route('auto')}}" class="highlight" title="Torna al catalogo auto">Catalogo</a></button>--}}

            <button><a href="{{route('user')}}" class="highlight" title="Torna alla home">Home</a></button>
        </ul>


    </div>
@endsection
