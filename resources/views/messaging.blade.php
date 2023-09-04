@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('title', 'Messaging')

{{-- parte user--}}
@section('content')
    @can('isUser')
        {{--        rotta che prende tutte le righe della tabella messaggi con l-id del utente e li stampa con un foreach (tipo le auto)--}}

        <div class="static">

            <h3>Sezione Messaggi</h3>

            <p>Premi su Aggiungi Domanda per inviare un messaggio all'Amministratore</p>

            <form method="POST" action="{{ route('sendMessageToAdmin') }}">

                @csrf

                <textarea name="userMessage" rows="4" placeholder="Scrivi la tua domanda qui"></textarea>

                <button type="submit">Invia</button>

            </form>


            {{-- Display User's Message --}}

            <div class="user-message">

                <h2>Your Message</h2>

                <p>{{ $userMessage }}</p>

            </div>


            {{-- Display Admin's Response --}}

            @if (!empty($adminResponse))

                <div class="admin-response">

                    <h2>Admin's Response</h2>

                    <p>{{ $adminResponse }}</p>

                </div>

            @else

                <div class="admin-response">

                    <h2>Admin's Response</h2>

                    <p>No response from admin yet.</p>

                </div>

            @endif

        </div>
    @endcan


    {{--    parte admin--}}
    @can('isAdmin')
        @php
        $controller=new \App\Http\Controllers\UserController();
         @endphp
        @if (session('success'))
            <span class="formerror">{{ session('success') }}</span>
        @endif
        @if (session('error'))
            <span class="formerror">{{ session('error') }}</span>
        @endif

        {{--        rotta che stampa gli id di tutti quelli che mandano messaggi --}}
        @foreach($inbox as $item)
            @php
                $utente=$controller->getUtentefromID($item->userId);
            @endphp
            <form id="formRispondi" action='{{route('rispondiAdmin')}}'>
                <div>
                    <p>
                        <strong>{{$utente->nome}} {{$utente->cognome}}</strong><br>
                        <strong>ID:{{$item->userId}}</strong><br>
                        {{$item->userMessage}}<br>
                    </p>
                </div>
                <input type="hidden" name="messageId" value="{{$item->id}}">
                <input type="hidden" name="userId" value="{{$item->userId}}">
                <input type="hidden" name="user" value="{{$utente}}">
                <label>
                    <input type="text" name="response" placeholder="Inserici la tua risposta a questo messaggio">
                </label>

                <button id="rispondi">
                    @if($item->hasResponse)
                        Aggiorna la risposta a questo messaggio
                    @else
                        Rispondi a questo messaggio
                    @endif
                </button>
            </form>
        @endforeach
        {{--        seleziona un messaggio--}}
        {{--        inserisce risposta oppure modifica la risposta--}}
    @endcan
@endsection
