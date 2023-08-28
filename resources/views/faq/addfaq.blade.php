@extends('layouts.admin')

@section('title', 'Add Faq')

@section('scripts')

@parent
<script src="{{ asset('js/functions.js') }}" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('#addFaqForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('storefaq') }}",
                data: $(this).serialize(),
                success: function (response) {
                    $('#resultMessage').html('<div class="alert alert-success">Faq added successfully</div>');
                    window.location.href = "{{ route('admin') }}";
                },
                error: function (error) {
                    $('#resultMessage').html('<div class="alert alert-danger">Failed to add faq</div>');
                }
            });
        });
    });
</script>

@endsection

@section('content')
<div class="static">
    <h3>Add New Faq</h3>

    <form id="addFaqForm" method="POST" action="{{ route('storefaq') }}">
                @csrf

        <div class="form-group">
            <label for="domanda">Domanda</label>
            <input type="text" name="domanda" id="domanda" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="risposta">Risposta</label>
            <input type="text" name="risposta" id="risposta" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add New Faq</button>
    </form>
    <div id="resultMessage" style="margin-top: 20px;"></div>
</div>

@endsection
