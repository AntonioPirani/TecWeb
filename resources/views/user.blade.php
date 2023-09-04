@extends('layouts.user')

@section('title', 'Area User')

@section('content')
    <div class="static">
        <h3>Area Utente</h3>
        <p>Benvenuto {{ Auth::user()->nome }} {{ Auth::user()->cognome }}</p>

        @isset($booking)
            @if($booking->count()==0 )
                <p>Sembra non ci siano prenotazioni, per effettuare una nuova prenotazione vai al <a
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
                                        $auto = $controller->getAutofromTarga($prenotazione->autoTarga);
                                        $interval=$prenotazione->dataFine->diff($prenotazione->dataInizio);
                                        $nDays=$interval->days;
                                        $costoTotale=$nDays *$auto->prezzoGiornaliero;
                                    @endphp
                                    @include('helpers/productImg', ['attrs' => 'imagefrm', 'imgFile' => $auto->foto])
                                </div>
                                <div class="info">
                                    <table>
                                        <tr>
                                            <td><p class="meta" >
                                                    <strong>Dettagli prenotazione</strong><br>
                                                    Data Inizio:{{$prenotazione->dataInizio->format('Y-m-d')}}<br>
                                                    Data Fine:{{$prenotazione->dataFine->format('Y-m-d')}}<br>
                                                    ID prenotazione:{{$prenotazione->id}}<br>
                                                    Status: {{$prenotazione->statoPrenotazione}}
                                                    @isset($costoTotale)
                                                        <br>
                                                        <span style=" color: #F93D00;">Costo totale: {{$costoTotale}} €</span><br>@endisset
                                                </p>
                                            </td>
                                            <td>
                                                <p class="meta">
                                                    <strong>Dettagli auto</strong><br>
                                                    Potenza: {{ $auto->potenza }} kW<br>
                                                    Tipo cambio: {{ $auto->tipoCambio }}<br>
                                                    Optional: {{ $auto->optional }}<br>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <ul>
                                    <li>
                                        <button>
                                            <a href="{{route('deletePrenotazione',['id'=>$prenotazione->id])}}">
                                                Elimina prenotazione
                                            </a>
                                        </button>
                                    </li>
{{--                                    <br>--}}
                                    <li>
                                        <button>
                                            <a href="{{route('modifyPrenotazione',['id'=>$prenotazione->id])}}">
                                                Modifica prenotazione
                                            </a>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        @endisset
    </div>
@endsection


