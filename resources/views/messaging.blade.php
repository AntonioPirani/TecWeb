@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.user')

@section('title', 'Messaging')

{{-- parte user--}}
@section('content')
    @can('isUser')
    {{--  rotta che prende tutte le righe della tabella messaggi con l-id del utente e li stampa con un foreach (tipo le auto)--}}

        <div class="static">

            <h3>Sezione Messaggi</h3>
            <p>Premi sul bottono Invia per inviare un messaggio all'Amministratore</p>

            {{-- Form per mandare messaggi all'admin --}}
            <form method="POST" action="{{ route('sendMessageToAdmin') }}">
                @csrf
                <textarea name="userMessage" rows="2" placeholder="Scrivi la tua domanda qui"></textarea>
                <button type="submit">Invia</button>
            </form>

            @if ($userMessages->isEmpty())
                <p>Nessuna domanda e' stata scritta dall'utente</p>
            @else
                <h3>Messaggi dell'utente</h3>
                <div class="message-list">
                    @foreach($userMessages as $message)
                        <div class="oneitem">
                            <div class="question">
                                <strong>La tua domanda:</strong>
                                <p>{{ $message->userMessage }}</p>
                            </div>
                            <div class="answer">
                                @if (!empty($message->adminResponse))
                                    <strong>Risposta dall'admin:</strong>
                                    <p>{{ $message->adminResponse }}</p>
                                @else
                                    <em>Ancora nessuna risposta dall'admin</em>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            

        </div>
    @endcan


    {{--    parte admin--}}
    @can('isAdmin')
        <div class="static">
            {{--Sezione per errori eventuali--}}
            @php
                $controller=new \App\Http\Controllers\UserController();
            @endphp



            <h3>Inbox</h3>
            @if (session('success'))
                <span style="background-color: #dff0d8; color: #26c929; border: 1px solid #daebf4; padding: 3px;">{{ session('success') }}</span>
            @endif
            @if (session('error'))
                <span class="formerror">{{ session('error') }}</span>
            @endif
            {{--        rotta che stampa gli id di tutti quelli che mandano messaggi --}}

            @foreach($inbox as $item)
                @php
                    $utente=$controller->getUtentefromID($item->userId);
                @endphp
                <div class="oneitem">
                    <form id="formRispondi" action='{{route('rispondiAdmin')}}'>
                        <div>
                            {{--                            questiondiv--}}
                            <div class="question">
                                <p style="font-weight: bold; margin: 0;">
                                    <strong>{{$utente->nome}} {{$utente->cognome}}</strong><br>
                                    <strong>ID:{{$item->userId}}</strong><br></p>
                                <p style="margin: 0;">{{$item->userMessage}}<br></p>
                            </div>

                            @if($item->hasResponse)
                                <div class="answer">
                                    <p style="font-weight: bold; margin: 0;"><strong>Admin:</strong></p>
                                    <p style="margin: 0;">Response: {{$item->adminResponse}}</p>
                                </div>

                            @endif
                        </div>

                        <input type="hidden" name="messageId" value="{{$item->id}}">
                        <input type="hidden" name="userId" value="{{$item->userId}}">
                        <input type="hidden" name="user" value="{{$utente}}">
                        <label>
                            <input style="width: 300px; height: 50px;" type="text" name="response"
                                   placeholder="Inserici la tua risposta a questo messaggio">
                        </label>

                        <button id="rispondi">
                            @if($item->hasResponse)
                                Aggiorna la risposta a questo messaggio
                            @else
                                Rispondi a questo messaggio
                            @endif
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endcan
@endsection
