@extends('layouts.public')

@section('title', 'Registrazione')

@section('scripts')

@parent
<script src="{{ asset('js/functions.js') }}" ></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    //console.log('JavaScript is loaded.');

    var baseUrl = '{{ asset('') }}'; // URL base

    // Salva il valore di provincia e citta in modo da poterli ripristinare in caso di cambio di stato
    var originalProvinciaHtml = $('#provincia').prop('outerHTML');
    var originalCittaHtml = $('#citta').prop('outerHTML');

    // Il bottone per la registrazione è disattivato per default, verrà attivato in seguito
    $('#registra-button').prop('disabled', true);

    // quando il campo stato cambia:
    $('#stato').change(function () {
        var selectedStato = $(this).val();
        if (selectedStato === 'Italia') {
            // Attiva il campo provincia e popola le opzioni
            $('#provincia').replaceWith(originalProvinciaHtml);
            $('#provincia').prop('disabled', false);

            // Enable and populate the citta select field
            $('#citta').replaceWith(originalCittaHtml);
            $('#citta').prop('disabled', false);

            // funzione per popolare le province
            $.ajax({
                url: baseUrl + 'get-provinces', //url da chiamare
                method: 'GET',
                success: function (data) {
                    var provinciaSelect = $('#provincia');
                    provinciaSelect.empty(); //svuota il campo
                    
                    //aggingi al dropdown le province in base al formato restituito dal controller
                    $.each(data.provinces, function(index, province) {
                        provinciaSelect.append(new Option(province.text, province.value));
                    });
                },
                //province non trovate
                error: function () {
                    console.log('Error fetching provinces.');
                }
            });

            // quando il campo provincia cambia:
            $('#provincia').change(function () {
                var selectedProvince = $(this).val();
                if (selectedProvince) {
                    $('#citta').prop('disabled', false);
                    var citiesUrl = baseUrl + 'get-cities/' + selectedProvince;

                    //stesso procedimento di prima, ma per le citta
                    $.ajax({
                        url: citiesUrl,
                        method: 'GET',
                        success: function (data) {
                            var cittaSelect = $('#citta');
                            cittaSelect.empty(); 

                            $.each(data.citta, function(index, city) {
                                cittaSelect.append(new Option(city.text, city.value));
                            });
                        },
                        error: function () {
                            console.log('Error fetching cities.');
                        }
                    });
                } else {
                    $('#citta').prop('disabled', true);
                }
            });
        } else {
            // Se non è selezionato lo stato Italia, trasforma i dropdown menu di provincia e citta in input text
            $('#provincia').replaceWith('<input type="text" id="provincia" name="provincia" class="input" placeholder="Inserisci Provincia">');
            $('#citta').replaceWith('<input type="text" id="citta" name="citta" class="input" placeholder="Inserisci Citta">');
        }
    });

    // Funzione che abilita/disabilita il bottone di registrazione in base al completamento della form. Se tutti i campi sono compilati
    // il bottone viene abilitato, altrimenti viene disabilitato.
    function checkFormCompletion() {
        var selectedStato = $('#stato').val();
        var nome = $('#nome').val();
        var cognome = $('#cognome').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var confirmPassword = $('#password-confirm').val();
        var dataNascita = $('#dataNascita').val();
        var occupazione = $('#occupazione').val();
        var provincia = $('#provincia').val();
        var citta = $('#citta').val();
        var via = $('#via').val();

        //se i campi non sono vuoti abilita il bottone
        if (
            nome && cognome && email && username && password && confirmPassword &&
            dataNascita && occupazione && selectedStato &&
            ((selectedStato === 'Italia' && provincia && citta) || selectedStato !== 'Italia') &&
            via
        ) {
            console.log('Form is complete.');
            $('#registra-button').prop('disabled', false);
        } else {
            console.log('Form is incomplete.');
            $('#registra-button').prop('disabled', true);
        }
    }

    // Ascolta se i campi della form cambiano e chiama la funzione checkFormCompletion()
    $('#stato, #nome, #cognome, #email, #username, #password, #password-confirm, #dataNascita, #occupazione, #provincia, #citta, #via').on('change keyup', function () {
        checkFormCompletion();
    });
});
</script>

@endsection

@section('content')
<div class="static">
    <h3>Registrazione</h3>
    <p>Utilizza questa form per registrarti al sito</p>

    <div class="container-contact">
        <div class="wrap-contact1">
            {{ Form::open(array('route' => 'register', 'class' => 'contact-form')) }}

            <div  class="wrap-input">
                {{ Form::label('nome', 'Nome', ['class' => 'label-input']) }}
                {{ Form::text('nome', '', ['class' => 'input', 'id' => 'nome']) }}
                @if ($errors->first('nome'))
                <ul class="errors">
                    @foreach ($errors->get('nome') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div  class="wrap-input">
                {{ Form::label('cognome', 'Cognome', ['class' => 'label-input']) }}
                {{ Form::text('cognome', '', ['class' => 'input', 'id' => 'cognome']) }}
                @if ($errors->first('cognome'))
                <ul class="errors">
                    @foreach ($errors->get('cognome') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            
             <div  class="wrap-input">
                {{ Form::label('email', 'Email', ['class' => 'label-input']) }}
                {{ Form::text('email', '', ['class' => 'input','id' => 'email']) }}
                @if ($errors->first('email'))
                <ul class="errors">
                    @foreach ($errors->get('email') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            
             <div  class="wrap-input">
                {{ Form::label('username', 'Nome Utente', ['class' => 'label-input']) }}
                {{ Form::text('username', '', ['class' => 'input','id' => 'username']) }}
                @if ($errors->first('username'))
                <ul class="errors">
                    @foreach ($errors->get('username') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            
             <div  class="wrap-input">
                {{ Form::label('password', 'Password', ['class' => 'label-input']) }}
                {{ Form::password('password', ['class' => 'input', 'id' => 'password']) }}
                @if ($errors->first('password'))
                <ul class="errors">
                    @foreach ($errors->get('password') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div  class="wrap-input">
                {{ Form::label('password-confirm', 'Conferma password', ['class' => 'label-input']) }}
                {{ Form::password('password_confirmation', ['class' => 'input', 'id' => 'password-confirm']) }}
            </div>

            <div  class="wrap-input">
                {{ Form::label('dataNascita', 'Data di Nascita', ['class' => 'label-input']) }}
                {{ Form::date('dataNascita', '', ['class' => 'input', 'id' => 'dataNascita']) }}
                @if ($errors->first('dataNascita'))
                <ul class="errors">
                    @foreach ($errors->get('dataNascita') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div class="wrap-input">
                {{ Form::label('occupazione', 'Occupazione', ['class' => 'label-input']) }}
                {{ Form::select('occupazione', ['Studente' => 'Studente', 'Lavoratore' => 'Lavoratore', 'Pensionato' => 'Pensionato'], null, ['class' => 'input', 'id' => 'occupazione', 'placeholder' => 'Seleziona Occupazione']) }}
                @if ($errors->first('occupazione'))
                <ul class="errors">
                    @foreach ($errors->get('occupazione') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div class="wrap-input">
                {{ Form::label('stato', 'Stato', ['class' => 'label-input']) }}
                {{ Form::select('stato', ['Italia' => 'Italia', 'PaeseUE' => 'Paese UE', 'PaeseNonUE' => 'Paese Non EU'], null, ['class' => 'input', 'id' => 'stato', 'placeholder' => 'Seleziona Stato']) }}
            </div>

            <div class="wrap-input">
                {{ Form::label('provincia', 'Provincia', ['class' => 'label-input']) }}
                {{ Form::select('provincia', [], null, ['class' => 'input', 'id' => 'provincia', 'placeholder' => 'Seleziona Provincia', 'disabled' => 'disabled']) }}
            </div>

            <div class="wrap-input">
                {{ Form::label('citta', 'Citta', ['class' => 'label-input']) }}
                {{ Form::select('citta', [], null, ['class' => 'input', 'id' => 'citta', 'placeholder' => 'Seleziona Citta', 'disabled' => 'disabled']) }}
            </div>

            <div  class="wrap-input">
                {{ Form::label('via', 'Via', ['class' => 'label-input']) }}
                {{ Form::text('via', '', ['class' => 'input', 'id' => 'via']) }}
                @if ($errors->first('via'))
                <ul class="errors">
                    @foreach ($errors->get('via') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div class="container-form-btn">                
                {{ Form::submit('Registra', ['class' => 'form-btn1', 'id' => 'registra-button']) }}
            </div>
            
            {{ Form::close() }}
        </div>
    </div>

</div>
@endsection
