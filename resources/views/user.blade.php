@extends('layouts.user')

@section('title', 'Area User')

@section('content')
    <div class="static">
        <h3>Area Utente</h3>
        <p>Benvenuto {{ Auth::user()->nome }} {{ Auth::user()->cognome }}</p>
        {{--        <p>Seleziona la funzione da attivare tra le scelte elencate sopra</p>--}}

        {{--        se la collezione di prenotazioni e vuota--}}
        @if($booking->count()==0)
            <p>Sembrano non esserci prenotazioni, per effettuare una nuova prenotazione vai al <a
                    href="{{route('auto')}}">Catalogo</a> cerca la auto che desideri e clicca Prenota!</p>
        @elseif($booking->count()==1)
            <p>Hai {{$booking->count()}} prenotazione</p>
        @elseif($booking->count()>1)
            <h4>Qui puoi vedere le tue prenotazioni:</h4>

        <p>Hai {{$booking->count()}} prenotazioni</p>
        @endif



            @foreach ($booking as $prenotazione )
                <div class="prod">
                    <div class="prod-bgtop">
                        <div class="prod-bgbtm">
                            <div class="oneitem">
                                <div class="image">
                                    @php
                                        $controller=new \App\Http\Controllers\UserController();
                                        $auto = $controller->getAutofromTarga($prenotazione->autoTarga)
                                    @endphp
                                    @include('helpers/productImg', ['attrs' => 'imagefrm', 'imgFile' => $auto->foto])
                                </div>
                                <div class="info">
                                    <h1 class="title">Modello: {{ $auto->marca }} {{ $auto->modello }}</h1>
                                    <p class="meta">Numero posti: {{ $auto->posti }}<br>
                                        Potenza: {{ $auto->potenza }} cv<br>
                                        Tipo cambio: {{ $auto->tipoCambio }}<br>
                                        Optional: {{ $auto->optional }}<br>
                                        Inizio prenotazione:{{$prenotazione->dataInizio}}<br>
                                        Fine prenotazione:{{$prenotazione->dataFine}}<br>

                                    </p>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
{{--        @endif--}}


    </div>
@endsection


