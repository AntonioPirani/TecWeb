@extends('layouts.admin')

@section('title', 'Stats')

@section('content')
    <div class="static">
        <h1>Monthly Statistiche Mensili per il {{ date('Y') }}</h1>
        <table style="margin-left: 10px;">
            <thead>
                <tr>
                    <th style="padding-right: 20px; text-align: center;">Mese</th>
                    <th style="text-align: center;">Affitti Totali</th>
                </tr>
            </thead>
            <tbody>
                @php
                $currentYear = date('Y');
                $months = [
                    1 => 'Gennaio',
                    2 => 'Febbraio',
                    3 => 'Marzo',
                    4 => 'Aprile',
                    5 => 'Maggio',
                    6 => 'Giugno',
                    7 => 'Luglio',
                    8 => 'Agosto',
                    9 => 'Settembre',
                    10 => 'Ottobre',
                    11 => 'Novembre',
                    12 => 'Dicembre',
                ];
                @endphp

                @foreach($months as $monthNumber => $monthName)
                    @php
                    $totalRentalsForMonth = $monthlyRentals[$monthNumber] ?? 0;
                    @endphp
                    <tr>
                        <td style="padding-right: 20px; text-align: center;">{{ $monthName }}</td>
                        <td style="text-align: center;">{{ $totalRentalsForMonth }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
