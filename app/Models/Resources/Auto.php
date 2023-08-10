<?php

namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model {

    protected $table = 'auto';  
    protected $primaryKey = 'targa';    //la targa è l'ID
    
    // targa non modificabile da un HTTP Request (Mass Assignment)
    protected $guarded = ['targa'];

    public $timestamps = false;

    protected $fillable = [
        'prezzo_giornaliero',
        'carburante',
        'modello',
        'numero_posti',
        'cilindrata',
        'tipo_cambio',
        'numero_porte',
        'climatizzazione',
        'radio',
        'gps',
        'cruise_control',
        'bluetooth',
    ];

    // Restituisce tutte le auto
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
    }


    // // Realazione One-To-One con Category
    // public function prodCat() {
    //     return $this->hasOne(Category::class, 'catId', 'catId');
    // }

}