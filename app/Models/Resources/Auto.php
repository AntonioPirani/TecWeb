<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model {

    protected $table = 'auto';
    protected $primaryKey = 'targa';    //la targa è l'ID

    // targa non modificabile da un HTTP Request (Mass Assignment)
    protected $casts = [
        'targa'=>'string',
    ];

    public $timestamps = false;

    protected $fillable = [
        'targa',
        'modello',
        'marca',
        'prezzoGiornaliero',
        'posti',
        'potenza',
        'tipoCambio',
        'optional',
        'foto'
    ];

    public function prenotazione()
    {
        return $this->hasMany(Prenotazione::class, 'autoTarga', 'targa');
    }

}
