<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBookingRequest;
use App\Models\Resources\Prenotazione;
use App\Models\User;

class UserController extends Controller {
    protected $_userModel;

    public function __construct() {
        $this->_userModel = new User;
        $this->middleware('can:isUser');
    }

    public function index() {
        return view('user');
    }

    public function newPrenotazione(NewBookingRequest $request){

        $booking=new Prenotazione;
        $booking->fill($request->validated());
        $booking->save();
        return view('user');
    }

}
