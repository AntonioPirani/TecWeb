<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBookingRequest;
use App\Models\Resources\Prenotazione;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {

    public function index() {
        return view('user');
    }

    public function storePrenotazione(NewBookingRequest $request): \Illuminate\Http\JsonResponse
    {

        $booking=new Prenotazione;
//        $booking->userId=$this->_userModel->username;
        $booking->fill($request->validate(
            ['userId' => 'optional|string',
            'autoTarga' => 'optional|string|max:7',
            'dataInizio' => 'required|date',
            'dataFine' => 'required|date',
            'statoPrenotazione' => 'optional|string']));

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
