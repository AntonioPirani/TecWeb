@extends('layouts.user')
@section('title','Update Booking')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{--<script>
        $(document).ready(function () {
            $('#modificaPrenotazione').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('updatePrenotazione')}}",
                    data: $(this).serialize(),
                    success: function (response) {
                        // Display the success message
                        $('#resultMessage').html('<p>Booking modified successfully</p>');

                        window.location.href = "{{ route('auto') }}";
                    },
                    error: function (error) {
                        // Display the error message
                        $('#resultMessage').html('<div class="alert alert-danger">Failed to modify booking</div>');
                        window.location.href = "{{ route('auto') }}";
                    }
                });
            });
        });
    </script>--}}

@endsection()


@section('content')
    <div class="static">
        <h3>Modifica prenotazione</h3>
        <div>
            <p>Qui puoi modificare la tua prenotazione con id: {{$id}}</p>
          @php
                $messaggio='';$warning='';
                $targa=\App\Models\Resources\Prenotazione::where('id',$id)->value('autoTarga');
                $allPrenotazioni=\App\Models\Resources\Prenotazione::where('autoTarga',$targa)->get();

                if($allPrenotazioni->isEmpty()){$messaggio='Questa auto non ha prenotazioni in previsto,scegli le date che preferisci';}
                else{
                    $messaggio ='Questa auto è già prenotata';
                    foreach ($allPrenotazioni as $prenotazione){
                        $messaggio =$messaggio . ' dal ' . $prenotazione->dataInizio->format('Y-m-d') . ' al ' . $prenotazione->dataFine->format('Y-m-d')  ;
                        $messaggio =$messaggio . " \n ";
                    }
                }
                $prenotazioniUtente=\App\Models\Resources\Prenotazione::where('userId',\Illuminate\Support\Facades\Auth::user()->id)->get();
                if($prenotazioniUtente->isNotEmpty()){
                    $warning ="Attenzione, hai già delle prenotazioni in programma che vedi qui di seguito: ";
                    foreach ($prenotazioniUtente as $prenotazione){
                        $warning .= " dal "  . $prenotazione->dataInizio->format('Y-m-d') . " al " . $prenotazione->dataFine->format('Y-m-d') . " , " ;
                    }
                    $warning =$warning .  'ricorda che non puoi fare una prenotazione con data sovrapposta ad una prenotazione già in programma';
                }else{$warning =$warning . 'Non hai altre prenotazioni in programma scegli la data che preferisci';}
            @endphp
            @if($messaggio!=='') <p>{{$messaggio}}</p>@endif
            @if($warning!=='') <p>{{$warning}}</p>@endif
        </div>

        <form id="modificaPrenotazione" method="POST" action="{{ route('updatePrenotazione') }}">
            @csrf

            <input type="hidden" name="id" value="{{$id}}">

            <div class="form-group">
                <label for="dataInizio">Inizio nolleggio:
                <input type="date" name="dataInizio" class="form-control" required></label>
            </div>
            <div class="form-group">
                <label for="dataFine">Fine nolleggio:
                <input type="date" name="dataFine" class="form-control" required></label>
            </div>

            <input type="hidden" name="statoPrenotazione" value="modificata">

            <button type="submit" class="btn btn-primary">Modifica prenotazione</button>
        </form>
        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>

@endsection
