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
        $request->validate([
            'minPrice','maxPrice','numero_posti'=>'numeric',
            'dataInizio','dataFine'=>'date',
        ]);
        $filteredAuto = collect([]);
        if ($request->has('numero_posti')) {
            $itemsToAdd=Auto::where('numero_posti', $request->input('numero_posti'));
            $filteredAuto->merge($itemsToAdd);
        }

//        $filteredAuto = Auto::whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')])->paginate(3);


        // Check if minPrice and maxPrice are provided
//        if ($request->has('numero_posti')) {
//            $itemsToAdd=Auto::where('numero_posti', $request->input('numero_posti'));
//            $filteredAuto->add($itemsToAdd);
//        }
//        if ($request->has('maxPrice')) {
//            $query->where('price', '<=', $request->input('maxPrice'));
//        }
//
//        // Check if minQuantity and maxQuantity are provided
//        if ($request->has('')) {
//            $query->where('posti',$request->input('numero_posti'));
//        }
//        if ($request->has('maxQuantity')) {
//            $query->where('quantity', '<=', $request->input('maxQuantity'));
//        }

        // Retrieve filtered products
//        $filteredAuto = $query->get();
        if ($filteredAuto->isEmpty()){return redirect(route('auto'))->with('error','Nessuna auto soddisfa i filtri');}
        return view('catalog', ['products' => $filteredAuto]);
    }


}
