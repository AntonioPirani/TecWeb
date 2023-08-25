<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Resources\Auto;
use Illuminate\Support\Facades\Log;


class PublicController extends Controller
{


    public function showAuto()
    {
        $autos = Auto::paginate(3); // Retrieve all records from the Auto table

        return view('showAuto', ['autos' => $autos]);
    }
    //TODO fare una funzione che restituisca un catalogo secondo i filtri richiesti

}
