<?php

namespace App\Http\Controllers;

use App\Models\Resources\Citta; 

class CittaController extends Controller
{
    //ottieni le province ordinate in ordine alfabetico
    public function getProvinces()
    {
        $province = Citta::distinct()
            ->orderBy('provincia', 'asc')
            ->pluck('provincia');

        //setta i valori per la view
        $provinces = [];
        foreach ($province as $prov) {
            $provinces[] = [
                'value' => $prov,
                'text' => $prov,
            ];
        }
        //ritorna i dati per la view
        return response()->json(['provinces' => $provinces]);
    }

    //ottieni le citta sotto la provincia immessa
    public function getCities($province)
    {
        $citta = Citta::where('provincia', $province)->get();

        // trasforma i dati in un formato compatibile con la view
        $formattedCities = $citta->map(function ($city) {
            return [
                'value' => $city->comune, 
                'text' => $city->comune,
            ];
        });

        return response()->json(['citta' => $formattedCities]);
    }

}
