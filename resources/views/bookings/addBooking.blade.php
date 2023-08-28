@extends('layouts.user')
@section('title','Add Booking')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#newBookingForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('storePrenotazione')}}" ,
                    data: $(this).serialize(),
                    success: function (response) {
                        // Display the success message
                        $('#resultMessage').html('<div class="alert alert-success">Booking added successfully</div>');

                        window.location.href = "{{ route('user') }}";
                    },
                    error: function (error) {
                        // Display the error message
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to add booking</div>');
                    }
                });
            });
        });
    </script>

@endsection()


@section('content')
    <div class="static">
        <h3>Add New Booking</h3>
        <div>
            <p>Targa auto: {{ $targa }}</p>
        </div>

        <form id="newBookingForm" method="POST" action="{{ route('storePrenotazione') }}">
            @csrf

            <div class="form-group">
                <label for="startDate">Inizio nolleggio:</label>
                <input type="date" name="dataInizio" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="finishDate">Fine nolleggio:</label>
                <input type="date" name="dataFine" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="hidden" name="autoTarga" value="{{$targa}}" class="form-control" required>
            </div>

            {{--<div class="form-group">
                <label for="userId">Surname</label>
                <input type="text" name="surname" id="userId" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" class="form-control" required>
            </div>--}}


            <!-- Add more form fields as needed -->

            <button type="submit" class="btn btn-primary">Add Booking</button>
        </form>
        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>

@endsection
