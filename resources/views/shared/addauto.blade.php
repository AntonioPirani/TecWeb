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

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "{{ route('storeauto') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#resultMessage').html('<div class="alert alert-success">Auto added successfully</div>');
                    var userRole = "{{ Auth::user()->role }}"; // Assuming you have a 'role' field in your user model

                    if (userRole === 'admin') {
                        window.location.href = "{{ route('admin') }}";
                    } else if (userRole === 'staff') {
                        window.location.href = "{{ route('staff') }}";
}
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
        <h3>Aggiungi Auto</h3>
        <p>Utilizza questa form per inserire una nuova auto nel Catalogo</p>

        <div class="container-contact"> <!-- lo stile compatto e incolonnato -->
            <div class="wrap-contact"> <!-- lo sfondo azzurro -->
                <form id="addAutoForm" method="POST" action="{{ route('storeauto') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="targa">Targa</label>
                        <input type="text" name="targa" id="targa" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="modello">Modello</label>
                        <input type="text" name="modello" id="modello" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="marca">Marca</label>
                        <input type="text" name="marca" id="marca" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="prezzoGiornaliero">Prezzo Giornaliero</label>
                        <input type="text" name="prezzoGiornaliero" id="prezzoGiornaliero" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="posti">Posti</label>
                        <input type="text" name="posti" id="posti" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="potenza">Potenza</label>
                        <input type="text" name="potenza" id="potenza" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="tipoCambio">Tipo di Cambio</label>
                        <select name="tipoCambio" id="tipoCambio" class="form-control" required>
                            <option value="manuale">Manuale</option>
                            <option value="automatico">Automatico</option>
                        </select>
                    </div>


                    <div class="wrap-input  rs1-wrap-input">
                        <label for="optional">Optional</label>
                        <input type="text" name="optional" id="optional" class="form-control" required>
                    </div>

                    <div class="wrap-input  rs1-wrap-input">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control-file" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Aggiungi Auto</button>
                </form>
            </div>
        </div>

        <div id="resultMessage" style="margin-top: 20px;"></div>

    </div>
@endsection
