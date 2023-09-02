<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Resources\Auto;
use Illuminate\Support\Facades\Log;


class PublicController extends Controller
{

    protected $_catalogModel;

    public function __construct() {
        $this->_catalogModel = new Catalog;
    }

    public function showAuto() {

        $autos = Auto::paginate(3);
        return view('catalog', ['products' => $autos]); //TODO mostra solo le auto prenotabili in un periodo di tempo

    }


}
