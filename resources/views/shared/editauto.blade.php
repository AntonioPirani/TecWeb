@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.staff')

@section('title', 'Add/Edit Auto')

@section('scripts')
    @parent
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('#lookupButton').on('click', function () {
                var targa = $('#lookupTarga').val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('getautodetails') }}", // Create this route in your routes file
                    data: { targa: targa },
                    success: function (response) {
                        $('#autoDetailsSection').show();

                        $('#modello').val(response.modello);
                        $('#marca').val(response.marca);
                        $('#prezzoGiornaliero').val(response.prezzoGiornaliero);
                        $('#posti').val(response.posti);
                        $('#potenza').val(response.potenza);
                        $('#tipoCambio').val(response.tipoCambio);
                        $('#optional').val(response.optional);
                        $('#disponibilita').val(response.disponibilita);

                        $('#targa').val(targa);

                        $('#resultMessage').html('<div class="alert alert-success">Auto found</div>');
                    },
                    error: function (error) {
                        $('#autoDetailsSection').hide();
                        $('#resultMessage').html('<div class="alert alert-danger">Auto not found</div>');
                    }
                });
            });

            $('#editAutoForm').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "{{ route('updateauto') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#resultMessage').html('<div class="alert alert-success">Auto updated successfully</div>');
                        var redirectRoute = "{{ auth()->user()->isAdmin() ? route('admin') : route('staff') }}";
                        window.location.href = redirectRoute;
                    },
                    error: function (error) {
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to update auto</div>');
                    }
                });
            });

            $('#deleteAutoButton').on('click', function () {
                if (confirm("Sei sicuro di voler eliminare questa auto?")) {
                    var targa = $('#targa').val();

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('deleteauto') }}", 
                        data: { targa: targa },
                        success: function (response) {
                            var redirectRoute = "{{ auth()->user()->isAdmin() ? route('admin') : route('staff') }}";
                            window.location.href = redirectRoute;
                        },
                        error: function (error) {
                            $('#resultMessage').html('<div class="alert alert-danger">Failed to delete auto</div>');
                        }
                    });
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="static">
        <h3>Gestisci Auto</h3>
        <p>Utilizza questa form per modificare o eliminare una nuova auto nel Catalogo</p>

        <div class="container-contact"> <!-- lo stile compatto e incolonnato -->
            <div class="wrap-contact"> <!-- lo sfondo azzurro -->
                <div class="wrap-input  rs1-wrap-input">
                    <label for="targa">Targa</label>
                    <input type="text" id="lookupTarga" class="form-control" required>
                    <button id="lookupButton" class="btn btn-primary">Cerca auto</button>
                </div>

                <div id="autoDetailsSection" style="display: none;">
                    <h4>Auto Details</h4>

                    <form id="editAutoForm" method="POST" action="{{ route('updateauto') }}">
                        @csrf

                        <input type="hidden" name="targa" id="targa">

                        <div class="wrap-input  rs1-wrap-input">
                            <label for="modello">Nuovo Modello</label>
                            <input type="text" name="modello" id="modello" class="form-control" required>
                        </div>
                        
                        <div class="wrap-input  rs1-wrap-input">
                            <label for="marca">Nuova Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control" required>
                        </div>
                        
                        <div class="wrap-input  rs1-wrap-input">
                            <label for="prezzoGiornaliero">Nuovo Prezzo Giornaliero</label>
                            <input type="text" name="prezzoGiornaliero" id="prezzoGiornaliero" class="form-control" required>
                        </div>

                        <div class="wrap-input  rs1-wrap-input">
                            <label for="posti">Nuovo Numero Posti</label>
                            <input type="text" name="posti" id="posti" class="form-control" required>
                        </div>

                        <div class="wrap-input  rs1-wrap-input">
                            <label for="potenza">Nuova Potenza</label>
                            <input type="text" name="potenza" id="potenza" class="form-control" required>
                        </div>

                        <div class="wrap-input  rs1-wrap-input">
                            <label for="tipoCambio">Nuovo Tipo Cambio</label>
                            <select name="tipoCambio" id="tipoCambio" class="form-control" required>
                                <option value="manuale">Manuale</option>
                                <option value="automatico">Automatico</option>
                            </select>
                        </div>

                        <div class="wrap-input  rs1-wrap-input">
                            <label for="optional">Nuovi Optional</label>
                            <input type="text" name="optional" id="optional" class="form-control" required>
                        </div>

                        <div class="wrap-input  rs1-wrap-input">
                        <label for="foto" title="Per fare l'update è necessario ricaricare la foto immessa in fase di aggiunta in caso questa fosse la stessa">
                            Nuova Foto <i class="fas fa-info-circle" style="color: #007bff;"></i>
                        </label>
                            <input type="file" name="foto" id="foto" class="form-control-file" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Aggiorna Auto</button>
                        <button type="button" id="deleteAutoButton" class="btn btn-danger">Elimina Auto</button>
                    </form>

                </div>
            </div>
        </div>
        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>
@endsection
