@extends('layouts.admin')

@section('title', 'Edit FAQ')

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
            //Id della faq inserita dall'admin
            var id = $('#lookupId').val();

            //chiama il controller per restituire i dettagli della faq se trovata
            $.ajax({
                type: "GET",
                url: "{{ route('getfaqdetails') }}",
                data: { id: id },
                success: function (response) {
                    //Mostra i dettagli della faq
                    $('#faqDetailsSection').show();

                    //Setta i valori dei campi della faq nei campi del form
                    $('#domanda').val(response.domanda);
                    $('#risposta').val(response.risposta);
                    $('#id').val(id);

                    // Messaggio di conferma
                    $('#resultMessage').html('<div class="alert alert-success">FAQ trovata</div>');
                },
                error: function (error) {
                    // La faq non è stata trovata 
                    $('#faqDetailsSection').hide(); // Nascondi il form di modifica (se prima era stata trovata un'altra faq)
                    $('#resultMessage').html('<div class="alert alert-danger">FAQ non trovata</div>');
                }
            });
        });

        // Quando viene inviato il form di modifica della faq
        $('#editFaqForm').on('submit', function (e) {   // e = eventHandler
            e.preventDefault(); // Evita il comportamento di default del form (ad es: ricarica completa della pagina)

            $.ajax({
                type: "POST",
                url: "{{ route('updatefaq') }}",
                data: $(this).serialize(),
                success: function (response) {
                    $('#resultMessage').html('<div class="alert alert-success">Faq aggiornata con successo</div>');
                },
                error: function (error) {
                    $('#resultMessage').html('<div class="alert alert-danger">Errore nell\'aggiornamento della faq</div>');
                }
            });
        });

        $('#deleteFaqButton').on('click', function () {
            if (confirm("Sei sicuto di voler eliminare questa FAQ?")) {
                var id = $('#id').val();

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('deletefaq') }}",
                    data: { id: id },
                    success: function (response) {
                        // Una volta eliminata, ritora alla pagina admin
                        window.location.href = "{{ route('admin') }}";
                    },
                    error: function (error) {
                        $('#resultMessage').html('<div class="alert alert-danger">Errore nella cancellazione faq</div>');
                    }
                });
            }
        });
    });

</script>

@endsection

@section('content')
<div class="static">
    <h3>Modifica FAQ</h3>

    <div class="form-group">
        <label for="id">FAQ ID</label>
        <input type="text" id="lookupId" class="form-group" required>
        <button id="lookupButton" class="btn btn-primary">Cerca FAQ</button>
    </div>

    <!-- Sezione inizialmente nascosta -->
    <div id="faqDetailsSection" style="display: none;">
        <h4>Dettagli FAQ</h4>

        <form id="editFaqForm" method="POST" action="{{ route('updatefaq') }}">
            @csrf

            <input type="hidden" name="id" id="id">

            <div class="form-group">
                <label for="domanda">Domanda</label>
                <input type="text" name="domanda" id="domanda" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="risposta">Risposta</label>
                <textarea name="risposta" id="risposta" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Aggiorna FAQ</button>

            <button type="button" id="deleteFaqButton" class="btn btn-danger">Elimina FAQ</button>

        </form>
    </div>

    <div id="resultMessage" style="margin-top: 20px;"></div>
</div>

@endsection
