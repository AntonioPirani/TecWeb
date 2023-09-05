@extends('layouts.user')
@section('title','Add Booking')
@section('scripts')
    <script src="{{ asset('js/functions.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection()

@section('content')
    <div class="static">
        <h3>Add New Booking</h3>
        <div>
            <p>Targa auto: {{ $targa }};</p>
            @php
                //in questa sezione di php viene verificato se:
                //-lutente ha gia prenotazioni ed in caso stampa le date cosi da evitare che prenoti di nuovo in quelle date
                //-la macchina selezionata in base alla targa ha gia delle prenotazioni e quindi stampa le date delle
                // prenotazioni per far si che lutente eviti di prenotare in quelle date
                $messaggio='';$warning='';
                $allPrenotazioni=\App\Models\Resources\Prenotazione::where('autoTarga',$targa)->get();

                if($allPrenotazioni->isEmpty()){$messaggio='Questa auto non ha prenotazioni in previsto,scegli le date che preferisci';}
                else{
                    $messaggio ='Questa auto è già prenotata:';
                    foreach ($allPrenotazioni as $prenotazione){
                        $messaggio =$messaggio . ' dal ' . $prenotazione->dataInizio->format('Y-m-d') . ' al ' . $prenotazione->dataFine->format('Y-m-d') . ", " ;

                    }
                    $messaggio =$messaggio . 'seleziona una data in cui l\'auto non è già prenotata';

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
            @if($messaggio!=='')
                <p>{{$messaggio}}</p>
            @endif
            @if($warning!=='')
                <p>{{$warning}}</p>
            @endif

        </div>

        {{--        form nuova prenotazione        --}}
        <form id="newBookingForm" method="POST" action="{{ route('storePrenotazione') }}">
            @csrf

            <div class="form-group">
                <label for="dataInizio">Inizio nolleggio:
                    <input type="date" name="dataInizio" class="form-control" required>
                </label>
            </div>
            @error('dataInizio')
            <span class="formerror">La data di inizio nolleggio deve essere prima della data di fine nolleggio</span>
            @enderror
            <div class="form-group">
                <label for="dataFine">Fine nolleggio:
                    <input type="date" name="dataFine" class="form-control" required>
                </label>
            </div>

            @error('dataFine')
            <span class="formerror">La data di fine nolleggio deve essere dopo la data di inizio nolleggio</span>
            @enderror

            <div class="form-group">
                <input type="hidden" name="autoTarga" value="{{$targa}}" class="form-control" required>
            </div>

            <input type="hidden" name="statoPrenotazione" value="nuova">


            <button type="submit" class="btn btn-primary">Add Booking</button>
        </form>
        <div id="resultMessage" style="margin-top: 20px;"></div>
    </div>

@endsection
