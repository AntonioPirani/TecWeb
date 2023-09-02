<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Resources\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Collection;


class PublicController extends Controller
{

    protected $_catalogModel;

    public function __construct()
    {
        $this->_catalogModel = new Catalog;
    }

    public function showAuto()
    {

        $autos = Auto::orderBy('prezzoGiornaliero', 'desc')->paginate(3);
        return view('catalog', ['products' => $autos]);

    }

    public function filtraPrezzo(Request $request)
    {
        $request->validate([
            'minPrice' => 'required|numeric',
            'maxPrice' => 'required|numeric'
        ]);
        if ($request->input('maxPrice')<$request->input('minPrice')) {
            return redirect(route('auto'))->with('error', 'Attenzione! I prezzi non sono inseriti correttamente');
        }
        $filteredAuto = Auto::whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')])->paginate();
        if ($filteredAuto->isEmpty()) {
            return redirect(route('auto'))->with('error', 'Attenzione! Nessuna auto soddisfa i filtri inseriti');
        }
        return view('catalog', ['products' => $filteredAuto]);
    }

    public function filtraPosti(Request $request)
    {
        $request->validate([
            'posti' => 'required|numeric'
        ]);
        $filteredAuto = Auto::where('posti', $request->input('posti'))->paginate();


        if ($filteredAuto->isEmpty()) {
            return redirect(route('auto'))->with('error', 'Attenzione! Nessuna auto soddisfa i filtri inseriti');
        }

        return view('catalog', ['products' => $filteredAuto]);
    }


}
