{{--pagina dove lutente puo confermare di eliminare la prenotazione, si avvisa lutente che e' un azione irreversibile--}}
@extends('layouts.user')
@section('title','Delete Booking')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection()


@section('content')
    <div class="static">
        <h3>Cancella prenotazione</h3>
        <div>
            <p><strong>Attenzione! Questa azione è irreversibile.</strong></p>
        </div>

        <form id="cancellaPrenotazione" method="POST" action="{{ route('cancellaPrenotazione') }}">
            @csrf

            <input type="hidden" name="id" value="{{$id}}">

            <button type="submit" class="btn btn-primary">Cancella definitivamente la tua prenotazione</button>
        </form>
        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>

@endsection
