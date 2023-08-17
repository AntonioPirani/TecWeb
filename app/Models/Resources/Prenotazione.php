<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resources\Auto;
use App\Models\User;


class Prenotazione extends Model{

    //id automaticamente definito dal framework
    protected $table = 'prenotazioni';

    protected $fillable = ['dataInizio','dataFine'];

    protected $guarded =['autoTarga','statoPrenotazione','userId'];

   public function getLastBookings($limit){
       return $this->orderBy('timestamps','desc')->limit($limit)->get(); //aggiungere al controller delle prenotazion
   }

}
