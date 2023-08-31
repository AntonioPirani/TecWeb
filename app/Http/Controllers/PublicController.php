<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Resources\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PublicController extends Controller
{

    protected $_catalogModel;

    public function __construct() {
        $this->_catalogModel = new Catalog;
    }

    public function showAuto() {

        $autos = Auto::orderBy('prezzoGiornaliero','desc')->paginate(3);
        return view('catalog', ['products' => $autos]);

    }

    public function filters(Request $request){
        //controlla se la form e tutta vuota
        if($request->isNotFilled('minPrice','maxPrice','posti')){
            return redirect(route('auto'))->with('error','Attenzione! Nessun filtro è stato inserito, perfavore inserisci i filtri prima di inviare il modulo');
        }

        $filteredAuto = collect();
        if ($request->has('minPrice')){$minPrice = $request->input('minPrice');}
        if ($request->has('maxPrice')){$maxPrice = $request->input('maxPrice');}
        if ($request->has('posti')){$posti = $request->input('posti');}
        $query = Auto::query();
        if($minPrice){$query->where('prezzoGiornaliero', '>=', $request->input('minPrice'));}
        if($maxPrice){$query->where('prezzoGiornaliero', '<=', $request->input('maxPrice'));}
        if($posti){$query->where('posti',$request->input('posti'));}

        $filteredAuto = $query->paginate(3);




//        elseif($request->has('minPrice') and $request->isNotFilled('maxPrice') and $request->isNotFilled('posti')){
//            $filteredAuto = Auto::where('prezzoGiornaliero', '>=', $request->input('minPrice'))->paginate(3);
//        }
//        elseif($request->has('maxPrice') and $request->isNotFilled('minPrice') and $request->isNotFilled('posti')){
//            $filteredAuto = Auto::where('prezzoGiornaliero', '<=', $request->input('maxPrice'))->paginate(3);
//        }
//        elseif($request->has('minPrice') and $request->has('maxPrice') and $request->isNotFilled('posti')){
//            $filteredAuto = Auto::whereBetween('prezzoGionaliero',[$request->has('minPrice'),$request->input('maxPrice')])->paginate(3);
//        }
//        elseif($request->has('posti') and $request->isNotFilled('maxPrice') and $request->isNotFilled('minPrice')){
//            $filteredAuto = Auto::where('posti', $request->input('posti'))->paginate(3);
//        }


        if ($filteredAuto->isEmpty()){return redirect(route('auto'))->with('error','Attenzione! Nessuna auto soddisfa i filtri inseriti');}
        return view('catalog', ['products' => $filteredAuto]);
    }


}
