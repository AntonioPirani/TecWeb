@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Prenotazioni Per Mese')

@section('content')

<script src="{{ asset('js/functions.js') }}"></script>

<div class="static">
    <h1>Prenotazioni Auto per <span id="month-name">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</span> {{ date('Y') }}</h1>
    <form id="month-form">
        @csrf
        <label for="month">Seleziona un Mese:</label>
        <select name="month" id="month">
            @foreach(range(1, 12) as $monthNumber)
                <option value="{{ $monthNumber }}" {{ $month == $monthNumber ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $monthNumber, 1)) }}
                </option>
            @endforeach
        </select>
        <button type="submit">Visualizza</button>
    </form>

    <div id="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Utente</th>
                    <th>Modello</th>
                    <th>Marca</th>
                    <th>Targa</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prenotazioni as $prenotazione)
                    <tr>
                        <td>{{ $prenotazione->user->username }}</td>
                        <td>{{ $prenotazione->auto->modello }}</td>
                        <td>{{ $prenotazione->auto->marca }}</td>
                        <td>{{ $prenotazione->auto->targa }}</td>
                        <td>{{ $prenotazione->dataInizio }}</td>
                        <td>{{ $prenotazione->dataFine }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection