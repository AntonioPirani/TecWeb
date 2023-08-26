<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resources\Auto;
use App\Models\User;


class Prenotazione extends Model{

    //id automaticamente definito dal framework

    /*public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['autoTarga'] = $attributes['autoTarga'] ?? 'NULL';

    }*/

    protected $table = 'prenotazioni';

    protected $fillable = ['dataInizio','dataFine'];

    protected $guarded =['autoTarga','userId'];

   public function getLastBookings($limit){
       return $this->orderBy('timestamps','desc')->limit($limit)->get(); //aggiungere al controller delle prenotazion
   }

}
