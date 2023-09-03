@extends('layouts.public')

@section('title', 'Chi Siamo')

@section('content')
    <div class="static">

        <table>
            <tr>
                <td>
                    <h2>Chi siamo</h2>
                    <p>Siamo un team appassionato di esperti nel settore dell'automotive, determinati a rendere il tuo
                        noleggio auto un'esperienza senza stress e piacevole. Con anni di esperienza nel campo, ci
                        dedichiamo a fornire un servizio impeccabile, garantendo la massima comodità e soddisfazione in
                        ogni singolo chilometro.</p>
                </td>
                <td>
                    <h2>La nostra missione</h2>
                    <p>La nostra missione è offrirti non solo una semplice auto a noleggio, ma un compagno di viaggio
                        affidabile. Vogliamo rendere ogni viaggio un'avventura senza pensieri, offrendoti veicoli in
                        condizioni ottimali e un servizio clienti sempre pronto ad assisterti.</p>
                </td>
            </tr>
        </table>
        <div style="text-align: center;"><h2>
                <a href="{{ route('auto') }}" title="Home"> Partiamo! </a>
            </h2></div>

@endsection
