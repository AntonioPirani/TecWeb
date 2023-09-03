<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Collection;
use function GuzzleHttp\Promise\all;
use function PHPUnit\Framework\isEmpty;


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
        if ($request->validate([
            'minPrice' => 'required|numeric',
            'maxPrice' => 'required|numeric'])) {
            return redirect(route('auto'))->with('error-prezzo', 'Attenzione! Prezzi non inseriti correttamente');
        }
        if ($request->input('maxPrice') < $request->input('minPrice')) {
            return redirect(route('auto'))->with('error-prezzo', 'Attenzione! Il prezzo minimo è maggiore del prezzo massimo');
        }
        $filteredAuto = Auto::whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')])->paginate();
        if ($filteredAuto->isEmpty()) {
            return redirect(route('auto'))->with('error-prezzo', 'Attenzione! Nessuna auto soddisfa i filtri inseriti');
        }
        return view('catalog', ['products' => $filteredAuto]);
    }

    public function filtraPosti(Request $request)
    {
        if ($request->validate([
            'posti' => 'required|numeric'])) {
            return redirect()->back()->with('error-posti', 'i valori inseriti non sono corretti');
        }
        $filteredAuto = Auto::where('posti', $request->input('posti'))->paginate();


        if ($filteredAuto->isEmpty()) {
            return redirect(route('auto'))->with('error-posti', 'Attenzione! Nessuna auto soddisfa i filtri inseriti');
        }

        return view('catalog', ['products' => $filteredAuto]);
    }

    public function filtroAnd(Request $request)
    {
        if (!$request->validate([
            'minPrice', 'maxPrice', 'posti' => 'required|numeric'])) {
            return redirect()->back()->with('error-mixed', 'i valori inseriti non sono corretti');
        }
        $selectedAuto = Auto::whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')]);
        $finalCollection = $selectedAuto->where('posti', $request->input('posti'))->paginate();
        if ($finalCollection->isEmpty()) {
            return redirect()->back()->with('error-mixed', 'Nessuna auto soddisfa i requisiti inseriti');
        }
//        return $finalCollection;
        return view('catalog', ['products' => $finalCollection]);
    }

    public function filtroData(Request $request)
    {

        $allPrenotazioni = Prenotazione::all();
        if ($allPrenotazioni->isEmpty()){return redirect()->back()->with('error-data','Al momento non esiste nessuna prenotazione nel nostro database, puoi prenotare qualsiasi auto');}
        $fissaInizio = new DateTime($request->input('dataInizio'));//le date fisse inserite dall'utente che devono filtrare le auto
        $fissaFine = new DateTime($request->input('dataFine'));
        if ($fissaInizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fissaFine < $fissaInizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }
        $controller = new UserController();
        $idArray=array();

        foreach ($allPrenotazioni as $item) {
            if ($controller->modifyOverlap(new DateTime($item->dataInizio), $fissaInizio, new DateTime($item->dataFine), $fissaFine)) {
                //se item arriva qui vuol dire che non e' disponibile nel periodo inserito dall'utente
                //perche la funzione overlap restituisce falso quando non si overlappano le date
                $idArray[]=$item->autoTarga;

            }
        }
        $filtered=Auto::whereNotIn('targa',$idArray)->orderBy('prezzoGiornaliero','desc')->paginate();

        return view('catalog', ['products' => $filtered]);
    }


}
