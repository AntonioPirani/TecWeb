@extends('layouts.public')

@section('title', 'Registrazione')

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
                {{ Form::select('occupazione', ['option1' => 'Studente', 'option2' => 'Lavoratore', 'option3' => 'Pensionato'], null, ['class' => 'input', 'id' => 'occupazione', 'placeholder' => 'Seleziona Occupazione']) }}
                @if ($errors->first('occupazione'))
                <ul class="errors">
                    @foreach ($errors->get('occupazione') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
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

            <div  class="wrap-input">
                {{ Form::label('citta', 'Citta', ['class' => 'label-input']) }}
                {{ Form::text('citta', '', ['class' => 'input', 'id' => 'citta']) }}
                @if ($errors->first('citta'))
                <ul class="errors">
                    @foreach ($errors->get('citta') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>

            <div  class="wrap-input">
                {{ Form::label('stato', 'Stato', ['class' => 'label-input']) }}
                {{ Form::text('stato', '', ['class' => 'input', 'id' => 'stato']) }}
                @if ($errors->first('stato'))
                <ul class="errors">
                    @foreach ($errors->get('stato') as $message)
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            
            <div class="container-form-btn">                
                {{ Form::submit('Registra', ['class' => 'form-btn1']) }}
            </div>
            
            {{ Form::close() }}
        </div>
    </div>

</div>
@endsection
