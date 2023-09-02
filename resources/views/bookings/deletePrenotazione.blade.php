@extends('layouts.user')
@section('title','Delete Booking')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#cancellaPrenotazione').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('cancellaPrenotazione',['id'=>$id])}}" ,
                    data: $(this).serialize(),
                    success: function (response) {
                        // Display the success message
                        $('#resultMessage').html('<p>Booking added successfully</p>');

                        window.location.href = "{{ route('auto') }}";
                    },
                    error: function (error) {
                        // Display the error message
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to delete booking</div>');
                        window.location.href = "{{ route('auto') }}";
                    }
                });
            });
        });
    </script>

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
