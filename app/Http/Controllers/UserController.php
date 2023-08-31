<?php

namespace App\Http\Controllers;

//use App\Http\Requests\NewBookingRequest;
use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    public function index() {
        $prenotazione = Prenotazione::where('userId',Auth::user()->id)->get();
        return view('user',['booking'=>$prenotazione]);
    }

    public function storePrenotazione(Request $request)
    {
        $validatedData = $request->validate([
            'autoTarga' => 'required|string',
            'dataInizio' => 'required|date',
            'dataFine' => 'required|date',
            'statoPrenotazione' => 'optional|string']);


        $booking= new Prenotazione;
        $booking->fill($validatedData);
        $booking->autoTarga = $request->input('autoTarga');
        $booking->userId = Auth::user()->id;
        $booking->statoPrenotazione = 'nuova';
        if($booking->save()){
//            Prenotazione inserita
            Log::info('Prenotazione aggiunta' . $booking->primaryKey);
            return view('bookings.completedBooking',['prenotazione' => $booking]);
        }else{
//            Hold on, wait a minute, something ain't right
            Log::error('Failed to add booking');
            return response()->json(['message' => 'Failed to add booking'],500);
        }
    }

    public function addPrenotazione($targa){
        return view('bookings.addBooking',['targa' => $targa]);
    }

    public function getUtentefromID($id){
        $user = User::find($id);
        if(!$user){
            response('User not found',404);
        }
        return $user;
    }
    public function getAutofromTarga($targa){
        $auto = Auto::find($targa);
        if(!$auto){
            response('Auto not found',404);
        }
        return $auto;
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



}
