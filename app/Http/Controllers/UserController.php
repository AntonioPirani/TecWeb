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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {        //seleziona le prenotazioni dell utente in sessione
        $allPrenotazioni = Prenotazione::where('userId', Auth::user()->id)->get();
        return view('user', ['booking' => $allPrenotazioni]);
    }


    public function storePrenotazione(Request $request)
    {
        $validatedData = $request->validate([
            'autoTarga' => 'required|string',
            'dataInizio' => 'required|date|before:dataFine',
            'dataFine' => 'required|date|after:dataInizio',
            'statoPrenotazione' => 'required|string']);

        //dopo aver validato gli input inseriti nella pagina di addbooking, salva la targa, user id e data inizio fine
        $targa = $request->input('autoTarga');
        $userId = Auth::user()->id;
        $inizio = new DateTime($request->input('dataInizio'));
        $fine = new DateTime($request->input('dataFine'));

        //esegue controlli sulla data per verificare la sua correttezza (data passata oppure inizio successivo alla fine)
        if ($inizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fine < $inizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }


        //usa la funziona isCarAvailable per verificare che la macchina identificata tramite
        // la targa non sia gia prenotata da unaltro utente nel periodo specificato che va da $inizio a $fine
        //successivamente verifica tramite UserOverlappingBookings che lutente non abbia richiesto di fare
        // un altra prenotazione in un periodo che si sovrappone ad una prenotazione gia confermata
        if ($this->isCarAvailable($targa, $inizio, $fine) and !$this->UserOverlappingBookings($userId, $inizio, $fine)) {

            //dopo aver controllato la validita della richiesta in base alla macchina e alle prenotazioni gia presenti
            //crea una nuova prenotazione e la salva
            $booking = new Prenotazione;
            $booking->fill($validatedData);
            $booking->autoTarga = $request->input('autoTarga');
            $booking->userId = Auth::user()->id;

            if ($booking->save()) {
                //            Prenotazione inserita
                Log::info('Prenotazione aggiunta' . $booking->primaryKey);

                //redireziona alla pagina di prenotazione completata dove si effettua un breve recap della prenotazione
                return view('bookings.completedBooking', ['prenotazione' => $booking]);
            } else {
                //    errore        Hold on, wait a minute, something ain't right
                Log::error('Failed to add booking');
                return response()->json(['message' => 'Failed to add booking'], 500);
            }
        } elseif (!$this->isCarAvailable($targa, $inizio, $fine)) {//se la macchina e' occupata nel periodo in cui si chiede di prenotarla da un errore specifico
            return redirect()->back()->with('error', 'La data scelta non e disponibile perché si sovrappone con un\'altra prenotazione della macchina selezionata');
        } elseif ($this->UserOverlappingBookings($userId, $inizio, $fine)) {//se lutente tenta di prenorare un altra auto in un periodo in cui ha gia una prenotazione viene stampato un errore specifico
            //questa condizione e falsa quando le date si overlappano
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
            return redirect()->route('user')->with('success', 'Prenotazione cancellata correttamente.');
        } else {
//            errore Hold on, wait a minute, something ain't right
            return redirect()->route('user')->with('error', 'Qualcosa è andato storto nel cancellare la prenotazione.');
        }
    }

    public function modifyPrenotazione($id)
    {
        return view('bookings.updatePrenotazione', ['id' => $id]);
    }

    public function updatePrenotazione(Request $request)
    {
        //seleziona la prenotazione che corrisponde al id e la targa giusta
        $targa = Prenotazione::where('id', $request->input('id'))->value('autoTarga');
        $prenotazioneDaCambiare = Prenotazione::find($request->input('id'));
        $userId = Auth::user()->id;
        $inizio = new DateTime($request->input('dataInizio'));
        $fine = new DateTime($request->input('dataFine'));
        //controlla se le date richieste sono valide ( data iniziale passata oppure fine<inizio
        if ($inizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fine < $inizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }

        //verifica che il nuovo periodo nel quale si vuole prenotare la macchina non si vada a sovrapporre
        // con quell vecchio in caso si chiede allutente di inserire una nuova prenotazione
        if ($this->modifyOverlap(new DateTime($prenotazioneDaCambiare->dataInizio), $inizio, new DateTime($prenotazioneDaCambiare->dataFine), $fine)) {
            return redirect()->back()->with('error', "Attenzione! Il nuovo periodo di nolleggio che si vuole inserire si sovrappone al periodo originario.
            \n Si consiglia di eliminare questa prenotazione ed inserirne una nuova");
        }

        //questa parte e del tutto simile alla funzione di inserimento prenotazione vista sopra
        if ($this->isCarAvailable($targa, $inizio, $fine) and !$this->UserOverlappingBookings($userId, $inizio, $fine)) {
            if (!$booking = Prenotazione::where('id', $request->input('id'))) {
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
        } elseif ($this->UserOverlappingBookings($userId, $inizio, $fine)) {//questa condizione e falsa quando le date si overlappano
            return redirect()->back()->with('error', 'La data scelta non e disponibile perché la data richiesta per la modifica
            della prenotazione si sovrappone con un\'altra delle tue prenotazioni già in programma');
        }
    }


    public
    function getUtentefromID($id)
    {
        $user = User::find($id);
        if (!$user) {
            response('User not found', 404);
        }
        return $user;
    }

    public
    function getAutofromTarga($targa)
    {
        $auto = Auto::find($targa);
        if (!$auto) {
            response('Auto not found', 404);
        }
        return $auto;

    }


    public
    function isCarAvailable($targa, $inizio, $fine)
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

    public
    function UserOverlappingBookings($userId, $inizio, $fine) //ritorna false se le date NON si overlappano
    {
        $overlapping = false;

        $allPrenotazioni = Prenotazione::where('userId', $userId)->get();

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

    public function modifyOverlap($i1, $i2, $f1, $f2)
    {
        //i2 e f2 sono rispettivamente le date gia convertite usando newDateTime della prenotazione 'nuova' da inserire
        //i1 f1 sono le date vecchie rispetto al quale si controlla overlap
        //quindi se sono in mezzo al periodo gia presente cioe tra i1 e f1 da errore e lo stesso se si overlappano in altri modi
        $overlap = false;
        if ($i1 <= $i2 and $i2 <= $f1) {
            $overlap = true;
        }// data inizio dentro il periodo vecchio
        if ($i1 <= $f2 and $f2 <= $f1) {
            $overlap = true;
        }//data di fine dentro il periodo vecchio
        if ($i2 <= $i1 and $f2 >= $f1) {
            $overlap = true;
        }//il periodo vecchio e "compreso" nel nuovo
        return $overlap;//overlap e falso se non si overlappano
    }

    public function delete()
    {
        return view('delete_user');
    }

    public function deleteUser(Request $request)
    {
        $username = $request->input('username');

        // Find the user by username
        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->with('error', 'Utente non trovato');
        }

        // Check for references in other tables
        $references = DB::table('prenotazioni')
            ->where('userId', $user->id)
            ->count();

        if ($references > 0) {
            return back()->with('error', 'L\'utente ha prenotazioni attive, non può essere eliminato');
        }

        // No references found, proceed with the user deletion
        $user->delete();

        return redirect('/admin')->with('status', 'User deleted successfully');
    }

    public function edit()
    {
        return view('edituser');
    }

    public function editUser(Request $request)
    {
        $user = Auth::user();
        $userData = User::find($user->id);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'dataNascita' => 'required|date',
            'occupazione' => 'required|string|max:255',
            'indirizzo' => 'required|string|max:255',
            'new_password' => 'nullable|string|min:8|confirmed', // Validate the new password
        ]);

        // Update the user's profile fields
        $userData->update($validatedData);

        // Update the password if a new one is provided
        if ($request->filled('new_password')) {
            $userData->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
        }

        return redirect()->route('user')->with('success', 'Profile updated successfully.');
    }

}
