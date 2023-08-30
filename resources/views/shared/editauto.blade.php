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

                $.ajax({
                    type: "POST",
                    url: "{{ route('updateauto') }}",
                    data: $(this).serialize(),
                    success: function (response) {

                        $('#resultMessage').html('<div class="alert alert-success">Auto updated successfully</div>');
                    },
                    error: function (error) {
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to update auto</div>');
                    }
                });
            });

            $('#deleteAutoButton').on('click', function () {
                if (confirm("Are you sure you want to delete this auto?")) {
                    var targa = $('#targa').val();

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('deleteauto') }}", // Create this route in your routes file
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
        <h3>Edit Auto</h3>

        <div class="form-group">
            <label for="targa">Targa</label>
            <input type="text" id="lookupTarga" class="form-control" required>
            <button id="lookupButton" class="btn btn-primary">Cerca auto</button>
        </div>

        <div id="autoDetailsSection" style="display: none;">
            <h4>Auto Details</h4>

            <form id="editAutoForm" method="POST" action="{{ route('updateauto') }}">
                @csrf

                <input type="hidden" name="targa" id="targa">

                <div class="form-group">
                    <label for="modello">Nuovo Modello</label>
                    <input type="text" name="modello" id="modello" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="marca">Nuova Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="prezzoGiornaliero">Nuovo Prezzo Giornaliero</label>
                    <input type="text" name="prezzoGiornaliero" id="prezzoGiornaliero" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="posti">Nuovo Numero Posti</label>
                    <input type="text" name="posti" id="posti" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="potenza">Nuova Potenza</label>
                    <input type="text" name="potenza" id="potenza" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tipoCambio">Nuovo Tipo Cambio</label>
                    <input type="text" name="tipoCambio" id="tipoCambio" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="optional">Nuovi Optional</label>
                    <input type="text" name="optional" id="optional" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="disponibilita">Nuova Disponibilità (s/n)</label>
                    <input type="text" name="disponibilita" id="disponibilita" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="foto">Nuova Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control-file" required>
                </div>

                <button type="submit" class="btn btn-primary">Aggiorna Auto</button>
                <button type="button" id="deleteAutoButton" class="btn btn-danger">Elimina Auto</button>
            </form>

        </div>

        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>
@endsection
