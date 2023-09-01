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
        $inizio =  new DateTime($request->input('dataInizio'));
        $fine = new DateTime($request->input('dataFine'));
        $allPrenotazioni = Prenotazione::where('autoTarga', $targa)->get();

        foreach ($allPrenotazioni as $prenotazione) {
            if ($inizio >= $prenotazione->dataInizio
                and $inizio <= $prenotazione->dataFine) {
                //la data di inizio si trova in mezzo al periodo di nolleggio di un altra prenotazione
                return redirect('user')->with('error', 'La data scelta non e disponibile perché si sovrappone con un\'altra prenotazione della macchina selezionata');
            } elseif ($inizio <= $prenotazione->dataInizio and $fine >= $prenotazione->dataInizio) {
                //la data di fine si trova in mezzo al periodo di nolleggio di unaltra prenotazione
                return redirect('user')->with('error', 'La data scelta non e disponibile perché si sovrappone con un\'altra prenotazione della macchina selezionata');
            }
        }


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


        $booking = Prenotazione::where('id', $request->input('id'));
        if (!$booking) {
            // Handle the case where the booking record was not found
            return redirect('/user')->with('error', 'Booking not found');
        }
        $booking->update([
            'dataInizio' => $request->input('dataInizio'),
            'dataFine' => $request->input('dataFine'),
            'statoPrenotazione' => $request->input('statoPrenotazione')]);


        return redirect('/user')->with('success', 'Prenotazione aggiornata!');
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

        //seleziona tutte le prenotazioni di una stessa auto
        $allPrenotazioni = Prenotazione::where('autoTarga', $targa)->get();

        foreach ($allPrenotazioni as $prenotazione) {
            if ($inizio > $prenotazione->dataInizio
                and $inizio < $prenotazione->dataFine) {
                //la data di inizio si trova in mezzo al periodo di nolleggio di un altra prenotazione

                $available = false;
                break;
//                return false;
            } elseif ($inizio<$prenotazione->dataInizio and $fine > $prenotazione->dataInizio) {
                //la data di fine si trova in mezzo al periodo di nolleggio di unaltra prenotazione
                $available = false;
                break;
//                return false;
            }
        }
        return $available;
    }

}
