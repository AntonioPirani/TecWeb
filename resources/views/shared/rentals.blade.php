@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Prenotazioni Per Mese')

@section('content')
    <div class="static">
        <h1>Prenotazioni per {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ date('Y') }}</h1>
        <form action="{{ route('rentals') }}" method="GET">
            @csrf
            <label for="month">Seleziona un Mese:</label>
            <select name="month" id="month">
                <option value="1">Gennaio</option>
                <option value="2">Febbraio</option>
                <option value="3">Marzo</option>
                <option value="4">Aprile</option>
                <option value="5">Maggio</option>
                <option value="6">Giugno</option>
                <option value="7">Luglio</option>
                <option value="8">Agosto</option>
                <option value="9">Settembre</option>
                <option value="10">Ottobre</option>
                <option value="11">Novembre</option>
                <option value="12">Dicembre</option>
            </select>
            <button type="submit">Get Rentals</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
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
@endsection