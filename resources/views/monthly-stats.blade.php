@extends('layouts.admin')

@section('title', 'Stats')

@section('content')
    <div class="static">
        <h1>Statistiche Mensili per il {{ date('Y') }}</h1>
        <table>
            <thead>
                <tr>
                    <th>Mese</th>
                    <th>Affiti Totali</th>
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
                        <td>{{ $monthName }}</td>
                        <td>{{ $totalRentalsForMonth }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
