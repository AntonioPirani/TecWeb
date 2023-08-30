@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Add Auto')

@section('scripts')

@parent
<script src="{{ asset('js/functions.js') }}" ></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('#addAutoForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('storeauto') }}",
                data: $(this).serialize(),
                success: function (response) {
                    $('#resultMessage').html('<div class="alert alert-success">Auto added successfully</div>');

                    window.location.href = "{{ route('staff') }}";
                },
                error: function (error) {
                    $('#resultMessage').html('<div class="alert alert-danger">Failed to add auto</div>');
                }
            });
        });
    });
</script>
@endsection

@section('content')
    <div class="static">
        <h3>Add New Auto</h3>

        <form id="addAutoForm" method="POST" action="{{ route('storeauto') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="targa">Targa</label>
                <input type="text" name="targa" id="targa" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="modello">Modello</label>
                <input type="text" name="modello" id="modello" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="marca">Marca</label>
                <input type="text" name="marca" id="marca" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prezzoGiornaliero">Prezzo Giornaliero</label>
                <input type="text" name="prezzoGiornaliero" id="prezzoGiornaliero" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="posti">Posti</label>
                <input type="text" name="posti" id="posti" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="potenza">Potenza</label>
                <input type="text" name="potenza" id="potenza" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="tipoCambio">Tipo di Cambio</label>
                <input type="text" name="tipoCambio" id="tipoCambio" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="optional">Optional</label>
                <input type="text" name="optional" id="optional" class="form-control" required>
            </div>

            <!-- <div class="form-group">
                <label for="disponibilita">Disponibilità</label>
                <input type="text" name="disponibilita" id="disponibilita" class="form-control" required>
            </div> -->

            <div class="form-group">
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control-file" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Auto</button>
        </form>

        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>
@endsection
