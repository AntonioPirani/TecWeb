@extends('layouts.public')

@section('title', 'Messaging')

{{-- parte user--}}
@section('content')
    @can('isUser')
{{--        rotta che prende tutte le righe della tabella messaggi con l-id del utente e li stampa con un foreach (tipo le auto)--}}
    @endcan


{{--    parte admin--}}
    @can('isAdmin')
{{--        rotta che stampa gli id di tutti quelli che mandano messaggi --}}
{{--        seleziona un messaggio--}}
{{--        inserisce risposta oppure modifica la risposta--}}
    @endcan
@endsection
