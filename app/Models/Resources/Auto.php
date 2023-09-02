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



   /*  // Restituisce tutte le auto
    public function getAllAuto()
    {
        return Auto::select()->get();
    }

    // Restituisce tutte le auto con un certo numero di posti (per il filtro aggiuntivo)
    public function getAutoByNumeroPosti($numeroPosti)
    {
        return Auto::where('numero_posti', $numeroPosti)->get();
    }

    // Restituisce tutte le auto entro un certo tipo di prezzo (per il primo filtro)
    public function getAutoByPrezzo($prezzoMinimo, $prezzoMassimo)
    {
        return self::whereBetween('prezzo_giornaliero', [$prezzoMinimo, $prezzoMassimo])->get();
    } */


    // // Realazione One-To-One con Category
    // public function prodCat() {
    //     return $this->hasOne(Category::class, 'catId', 'catId');
    // }

    public function prenotazioni()
    {
        return $this->hasMany(Rental::class, 'autoTarga', 'targa');
    }

}
