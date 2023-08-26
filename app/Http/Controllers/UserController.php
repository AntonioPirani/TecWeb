<?php

namespace App\Http\Controllers;

//use App\Http\Requests\NewBookingRequest;
use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {

    public function index() {
        return view('user');
    }

    public function storePrenotazione(Request $request,$autoTarga): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'dataInizio' => 'required|date',
            'dataFine' => 'required|date',
            'statoPrenotazione' => 'optional|string']);


        $booking= new Prenotazione($validatedData);
        $booking->autoTarga = $autoTarga;
        $booking->userId = Auth::user()->id;
        $booking->statoPrenotazione = 'nuova';

        if($booking->save()){
//            Prenotazione inserita
            Log::info('Prenotazione aggiunta' . $booking->primaryKey);
            return response()->json(['message' => 'Booking added successfully']);
        }else{
//            something is wrong
            Log::error('Failed to add booking');
            return response()->json(['message' => 'Failed to add booking'],500);
        }
    }

    public function addPrenotazione(){
        return view('bookings.addBooking');
    }

}
