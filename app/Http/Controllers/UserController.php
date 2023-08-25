<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBookingRequest;
use App\Models\Resources\Prenotazione;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
    protected $_userModel;

    public function __construct() {
        $this->_userModel = new User;
        $this->middleware('can:isUser');
    }

    public function index() {
        return view('user');
    }

    public function storePrenotazione(NewBookingRequest $request){

        $booking=new Prenotazione;
        $booking->fill($request->validated());

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

    public function addBooking(){
        return view('bookings.addBooking');
    }

}
