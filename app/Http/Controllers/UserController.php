<?php

namespace App\Http\Controllers;

//use App\Http\Requests\NewBookingRequest;
use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {

        $allPrenotazioni = Prenotazione::where('userId', Auth::user()->id)->get();
//        foreach ($allPrenotazioni as $prenotazione) {
//            $numGiorni  = ($prenotazione->dataFine->diff($prenotazione->dataInizio));
//            $costoTot = ($prenotazione->prezzoGiornaliero*$numGiorni);
//        }
        return view('user', ['booking' => $allPrenotazioni]);

    }


    public function storePrenotazione(Request $request)
    {
        $validatedData = $request->validate([
            'autoTarga' => 'required|string',
            'dataInizio' => 'required|date|before:dataFine',
            'dataFine' => 'required|date|after:dataInizio',
            'statoPrenotazione' => 'required|string']);

        $targa = $request->input('autoTarga');
        $userId = Auth::user()->id;
        $inizio = new DateTime($request->input('dataInizio'));
        $fine = new DateTime($request->input('dataFine'));
        if ($inizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fine < $inizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }


        if ($this->isCarAvailable($targa, $inizio, $fine) and !$this->UserOverlappingBookings($userId, $inizio, $fine)) {

            $booking = new Prenotazione;
            $booking->fill($validatedData);
            $booking->autoTarga = $request->input('autoTarga');
            $booking->userId = Auth::user()->id;

            if ($booking->save()) {
                //            Prenotazione inserita
                Log::info('Prenotazione aggiunta' . $booking->primaryKey);
                return view('bookings.completedBooking', ['prenotazione' => $booking]);
            } else {
                //            Hold on, wait a minute, something ain't right
                Log::error('Failed to add booking');
                return response()->json(['message' => 'Failed to add booking'], 500);
            }
        } elseif (!$this->isCarAvailable($targa, $inizio, $fine)) {
            return redirect()->back()->with('error', 'La data scelta non e disponibile perché si sovrappone con un\'altra prenotazione della macchina selezionata');
        }elseif ($this->isCarAvailable($userId, $inizio, $fine)) {//questa condizione e falsa quando le date si overlappano
            return redirect()->back()->with('error', 'La data scelta non e disponibile perché la data richiesta per la modifica
            della prenotazione si sovrappone con un\'altra delle tue prenotazioni già in programma');
        }
    }

    public function addPrenotazione($targa)
    {
        return view('bookings.addBooking', ['targa' => $targa]);
    }

    public function deletePrenotazione($id)
    {
        return view('bookings.deletePrenotazione', ['id' => $id]);

    }

    public function cancellaPrenotazione(Request $request)
    {

        if (Prenotazione::where('id', $request->input('id'))->delete()) {
//            Prenotazione cancellata definitivamente
            Log::info('Prenotazione cancellata');
            session()->flash('success', 'Operation completed successfully.');

            return redirect()->route('user')->with('success', 'Prenotazione cancellata correttamente.');
        } else {
//            Hold on, wait a minute, something ain't right
            Log::error('Failed to delete booking');
            session()->flash('message', 'Operation failed.');
            return redirect()->route('user')->with('error', 'Qualcosa è andato storto nel cancellare la prenotazione.');
        }
    }

    public function modifyPrenotazione($id)
    {
        return view('bookings.updatePrenotazione', ['id' => $id]);
    }

    public function updatePrenotazione(Request $request)
    {
        $targa = Prenotazione::where('id', $request->input('id'))->value('autoTarga');
        $userId = Auth::user()->id;
        $inizio = new DateTime($request->input('dataInizio'));
        $fine = new DateTime($request->input('dataFine'));
        if ($inizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fine < $inizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }

        if ($this->isCarAvailable($targa, $inizio, $fine) and !$this->UserOverlappingBookings($userId, $inizio, $fine)) {
            if (!$booking = Prenotazione::where('id', $request->input('id'))) {
                // Handle the case where the booking record was not found
                return redirect()->back()->with('error', 'Booking not found');
            } else {
                $booking->update([
                    'dataInizio' => $inizio,
                    'dataFine' => $fine,
                    'statoPrenotazione' => 'modificata']);
                return redirect('user')->with('success', 'Prenotazione aggiornata!');
            }
        } elseif (!$this->isCarAvailable($targa, $inizio, $fine)) {
            return redirect()->back()->with('error', 'La data scelta non e disponibile perché si sovrappone con un\'altra prenotazione della macchina selezionata');
        }elseif ($this->isCarAvailable($userId, $inizio, $fine)) {//questa condizione e falsa quando le date si overlappano
            return redirect()->back()->with('error', 'La data scelta non e disponibile perché la data richiesta per la modifica
            della prenotazione si sovrappone con un\'altra delle tue prenotazioni già in programma');
        }

    }


    public function getUtentefromID($id)
    {
        $user = User::find($id);
        if (!$user) {
            response('User not found', 404);
        }
        return $user;
    }

    public function getAutofromTarga($targa)
    {
        $auto = Auto::find($targa);
        if (!$auto) {
            response('Auto not found', 404);
        }
        return $auto;

    }


    public function isCarAvailable($targa, $inizio, $fine)
    {
        $available = true;

        $allPrenotazioni = Prenotazione::where('autoTarga', $targa)->get();

        foreach ($allPrenotazioni as $prenotazione) {
            if ($inizio >= $prenotazione->dataInizio
                and $inizio <= $prenotazione->dataFine) {
                //la data di inizio si trova in mezzo al periodo di nolleggio di un altra prenotazione
                $available = false;
            } elseif ($inizio <= $prenotazione->dataInizio and $fine >= $prenotazione->dataInizio) {
                //la data di fine si trova in mezzo al periodo di nolleggio di unaltra prenotazione
                $available = false;
            }
        }
        return $available;
    }

    public function UserOverlappingBookings($userId, $inizio, $fine) //ritorna false se le date NON si overlappano
    {
        $overlapping = false;

        $allPrenotazioni = Prenotazione::where('userId', $userId)->get();
//        echo $allPrenotazioni;

        foreach ($allPrenotazioni as $prenotazione) {
            if ($inizio >= $prenotazione->dataInizio
                and $inizio <= $prenotazione->dataFine) {
                //la data di inizio si trova in mezzo al periodo di nolleggio di un altra prenotazione
                $overlapping = true;
            } elseif ($inizio <= $prenotazione->dataInizio and $fine >= $prenotazione->dataInizio) {
                //la data di fine si trova in mezzo al periodo di nolleggio di unaltra prenotazione
                $overlapping = true;
            }
        }
        return $overlapping;
    }

}
