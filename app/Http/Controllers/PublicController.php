<?php

namespace App\Http\Controllers;

use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;
use DateTime;
use Illuminate\Http\Request;


class PublicController extends Controller
{/*finale*/

    public function showAuto()
    {

        $autos = Auto::orderBy('prezzoGiornaliero', 'desc')->paginate(5);
        return view('catalog', ['products' => $autos]);

    }

    public function filtraPrezzo(Request $request)
    {
        //controlla se il prezzo massimo inserito e maggiore di quello minimo
        if ($request->input('maxPrice') < $request->input('minPrice')) {
            return redirect(route('auto'))->with('error-prezzo', 'Attenzione! Il prezzo minimo è maggiore del prezzo massimo');
        }

        //seleziona e impagina (tutte nella stessa) le auto che hanno prezzo compreso tra min e max
        $filteredAuto = Auto::whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')])->paginate();

        //verifica se nessuna auto soddisfa il filtro
        if ($filteredAuto->isEmpty()) {
            return redirect(route('auto'))->with('error-prezzo', 'Attenzione! Nessuna auto soddisfa i filtri inseriti');
        }
        //restituisce la vista con il vettore di auto filtrate
        return view('catalog', ['products' => $filteredAuto]);
    }

    public function filtraPosti(Request $request)
    {
        

        //seleziona le auto che soddisfano il numero di posti
        $filteredAuto = Auto::where('posti', $request->input('posti'))->paginate();
        //verifica se nessuna auto soddisfa il filtro
        if ($filteredAuto->isEmpty()) {
            return redirect(route('auto'))->with('error-posti', 'Attenzione! Nessuna auto soddisfa i filtri inseriti');
        }

        //restituisce la vista con il vettore di auto filtrate
        return view('catalog', ['products' => $filteredAuto]);
    }

    public function filtroAnd(Request $request)
    {
        if (!$request->validate([
            'minPrice', 'maxPrice', 'posti' => 'required|numeric'])) {
            return redirect()->back()->with('error-mixed', 'i valori inseriti non sono corretti');
        }
        //selezione delle auto che soddisfano i filtri inseriti
        $finalCollection = Auto::whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')])
            ->where('posti', $request->input('posti'))->paginate();

        //controllo se ci sono auto che soddisfano i filtri
        if ($finalCollection->isEmpty()) {
            return redirect()->back()->with('error-mixed', 'Nessuna auto soddisfa i requisiti inseriti');
        }

        return view('catalog', ['products' => $finalCollection]);
    }

    public function filtroData(Request $request)
    {

        $allPrenotazioni = Prenotazione::all();
        //verifica che ci sono prenotazioni inserite, se non ci sono restituisce un messaggio che avvisa lutente che non ha restrizioni sulla data di prenotazione
        if ($allPrenotazioni->isEmpty()) {
            return redirect()->back()->with('error-data', 'Al momento non esiste nessuna prenotazione nel nostro database, puoi prenotare qualsiasi auto');
        }

        //converte le stringhe delle date di inizio e fine allinterno della richiesta in dateTime object
        $fissaInizio = new DateTime($request->input('dataInizio'));//le date fisse inserite dall'utente che devono filtrare le auto
        $fissaFine = new DateTime($request->input('dataFine'));

        //verifica se la data di inizio e' passata (anche il giorno stesso e' segnalato come errore perche non si dovrebbe poter prenotare oggi per oggi)
        // oppure se la data di inizio e' successiva a quella di inizio
        if ($fissaInizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fissaFine < $fissaInizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }

        //istanza di user controller per andare ad utilizzare la funzione modifyoverlap
        $controller = new UserController();
        //vettore vuoto dove andranno collocate le targhe delle auto
        $idArray = array();

        //tramite la funzione modifyoverlap, si va a verificare per ogni prenotazione inserita se ci sono delle auto "occupate" nel periodo indicato nella richiesta
        //che va da $fissaInizio a $fissaFine.
        //Se questo si verifica entra nel if e salva la targa della macchina ($item) la cui prenotazione si sovrappone al periodo indicato nella richiesta
        foreach ($allPrenotazioni as $item) {
            if ($controller->modifyOverlap(new DateTime($item->dataInizio), $fissaInizio, new DateTime($item->dataFine), $fissaFine)) {
                //se item arriva qui vuol dire che non e' disponibile nel periodo inserito dall'utente
                //perche la funzione overlap restituisce falso quando non si overlappano le date
                $idArray[] = $item->autoTarga;

            }
        }
        //vanno selezionate tutte le auto che NON hanno la targa presente in $idArray
        //cioe si selezionano tutte le auto disponibili nel periodo che va da $fissaInizio a $fissaFine
        $filtered = Auto::whereNotIn('targa', $idArray)->orderBy('prezzoGiornaliero', 'desc')->paginate();

        return view('catalog', ['products' => $filtered]);
    }

    public function dataANDprezzo(Request $request)
    {
        //la prima parte di questa funzione cioe dove si selezionano le auto disponibili in base alla data specificata e'
        // identico al procedimento spiegato sopra
        $allPrenotazioni = Prenotazione::all();
        if ($allPrenotazioni->isEmpty()) {
            return redirect()->back()->with('error', 'Al momento non esiste nessuna prenotazione nel nostro database, puoi prenotare qualsiasi auto');
        }
        $fissaInizio = new DateTime($request->input('dataInizio'));//le date fisse inserite dall'utente che devono filtrare le auto
        $fissaFine = new DateTime($request->input('dataFine'));
        if ($fissaInizio < new DateTime(now())) {
            return redirect()->back()->with('error', 'La data di inizio è passata');
        } elseif ($fissaFine < $fissaInizio) {
            return redirect()->back()->with('error', 'La data di fine é precedente alla data di inizio');
        }
        $controller = new UserController();
        $idArray = array();

        foreach ($allPrenotazioni as $item) {
            if ($controller->modifyOverlap(new DateTime($item->dataInizio), $fissaInizio, new DateTime($item->dataFine), $fissaFine)) {
                //se item arriva qui vuol dire che non e' disponibile nel periodo inserito dall'utente
                //perche la funzione overlap restituisce falso quando non si overlappano le date
                $idArray[] = $item->autoTarga;


            }
        }

        //a questo punto oltre le auto disponibili nel periodo indicato si selezionano anche le auto che rientrano nella fascia di prezzo specificato
        $filtered = Auto::whereNotIn('targa', $idArray)
            ->whereBetween('prezzoGiornaliero', [$request->input('minPrice'), $request->input('maxPrice')])
            ->orderBy('prezzoGiornaliero', 'desc')->paginate();
        if ($filtered->isEmpty()) {
            return redirect()->back()->with('error', 'Nessuna auto soddisfa i filtri inseriti');
        }
        return view('catalog', ['products' => $filtered]);
    }
}
