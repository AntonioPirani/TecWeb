<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Citta; 

class CittaController extends Controller
{
    public function getProvinces()
    {
        $province = Citta::distinct()
            ->orderBy('provincia', 'asc')
            ->pluck('provincia');

        $provinces = [];
        foreach ($province as $prov) {
            $provinces[] = [
                'value' => $prov,
                'text' => $prov,
            ];
        }

        return response()->json(['provinces' => $provinces]);
    }

    public function getCities($province)
    {
        $citta = Citta::where('provincia', $province)->get();

        // Transform the data to include both 'value' and 'text' attributes
        $formattedCities = $citta->map(function ($city) {
            return [
                'value' => $city->istat, // Use a suitable field as the 'value'
                'text' => $city->comune, // Use a suitable field as the 'text'
            ];
        });

        return response()->json(['citta' => $formattedCities]);
    }

}
