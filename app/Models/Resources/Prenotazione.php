<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Prenotazione extends Model{


    protected $table = 'prenotazioni';

    protected $fillable = ['dataInizio','dataFine','statoPrenotazione'];

    protected $guarded =['autoTarga','userId'];
    protected $casts = [
        'dataInizio'=>'datetime:Y-m-d',
        'dataFine'=>'datetime:Y-m-d'];

   public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function auto()
    {
        return $this->belongsTo(Auto::class, 'autoTarga', 'targa');
    }

}
