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

    protected $fillable = ['dataInizio','dataFine','statoPrenotazione'];

    protected $guarded =['autoTarga','userId'];
    protected $casts = [
        'dataInizio'=>'datetime:Y-m-d',
        'dataFine'=>'datetime:Y-m-d'];

   public function getLastBookings($limit){
       return $this->orderBy('timestamps','desc')->limit($limit)->get(); //aggiungere al controller delle prenotazion
   }

   public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function auto()
    {
        return $this->belongsTo(Auto::class, 'autoTarga', 'targa');
    }

}
