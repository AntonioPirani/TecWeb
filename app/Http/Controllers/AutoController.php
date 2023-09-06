<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;

class AutoController extends Controller
{
    /**
     * Salvataggio della auto nel database
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'targa' => 'required|string|unique:auto,targa|max:7',
            'modello' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'prezzoGiornaliero' => 'required|string|max:255',
            'posti' => 'required|string|max:255',
            'potenza' => 'required|string|max:255',
            'tipoCambio' => 'required|string|max:255',
            'optional' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $auto = new Auto;
        $auto->targa = $validatedData['targa'];
        $auto->modello = $validatedData['modello'];
        $auto->marca = $validatedData['marca'];
        $auto->prezzoGiornaliero = $validatedData['prezzoGiornaliero'];
        $auto->posti = $validatedData['posti'];
        $auto->potenza = $validatedData['potenza'];
        $auto->tipoCambio = $validatedData['tipoCambio'];
        $auto->optional = $validatedData['optional'];

        // Salvataggio della immagine
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = $image->getClientOriginalName();
        } else {
            $imageName = NULL;
        }
        $auto->foto = $imageName;
        
        if (!is_null($imageName)) {
            $destinationPath = public_path() . '/images/autos';
            $image->move($destinationPath, $imageName);
        };

        if ($auto->save()) {
            return response()->json(['message' => 'Auto added successfully']);
        } else {
            return response()->json(['message' => 'Failed to add auto'], 500);
        }
    }
    
    public function add()
    {
        return view('shared.addauto');
    }

    /**
     * Restituisce se disponibile al momento di richiesta e se trovata l'auto con la targa desiderata
     *
     * @return \Illuminate\Http\Response
     */
    public function getAutoDetails(Request $request)
    {
        $targa = $request->input('targa');
        $today = now()->toDateString(); 

        $auto = Auto::where('targa', $targa)
            ->first();

        if ($auto && $this->isCarAvailable($targa, $today, $today)) {
            return response()->json($auto);
        } else {
            return response()->json(['message' => 'Auto non trovata o non disponibile'], 404);
        }
    }


    public function edit()
    {
        return view('shared.editauto');
    }

    /**
     * Aggiornamento dati dalla auto trovata con il metodo getAutoDetails
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'targa' => 'required|string|max:7',
            'modello' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'prezzoGiornaliero' => 'required|string|max:255',
            'posti' => 'required|string|max:255',
            'potenza' => 'required|string|max:255',
            'tipoCambio' => 'required|string|max:255',
            'optional' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Controlla se l'auto con la targa immessa esiste
        $targa = $request->input('targa');
        $auto = Auto::where('targa', $targa)->first();

        if (!$auto) {
            return response()->json(['message' => 'Auto non trovata'], 404);
        }

        // Controlla se c'è una foto associata all'auto
        if (!is_null($auto->foto)) {
            $existingImagePath = public_path('images/autos/') . $auto->foto;

            // Se c'è una nuova foto, elimina quella esistente
            if ($request->hasFile('foto')) {
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            } else {
                // Se non c'è una nuova foto, usa quella esistente
                $validatedData['foto'] = $auto->foto;
            }
        }

        // Riempe l'oggetto auto con i nuovi dati
        $auto->targa = $validatedData['targa'];
        $auto->modello = $validatedData['modello'];
        $auto->marca = $validatedData['marca'];
        $auto->prezzoGiornaliero = $validatedData['prezzoGiornaliero'];
        $auto->posti = $validatedData['posti'];
        $auto->potenza = $validatedData['potenza'];
        $auto->tipoCambio = $validatedData['tipoCambio'];
        $auto->optional = $validatedData['optional'];

        // Carica la nuova foto
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = $image->getClientOriginalName();
            $auto->foto = $imageName;

            $destinationPath = public_path() . '/images/autos';
            $image->move($destinationPath, $imageName);
        }

        if ($auto->save()) {
            return response()->json(['message' => 'Auto aggiornata con successo']);
        } else {
            return response()->json(['message' => 'Errore nell\'aggiornamento auto'], 500);
        }
    }

    /**
     * Eliminazione auto dal database
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $targa = $request->input('targa');
        $auto = Auto::where('targa', $targa)->first();

        if ($auto) {
            // Controlla se c'è una immagine
            if (!is_null($auto->foto)) {
                $existingImagePath = public_path('images/autos/') . $auto->foto;
                
                // E in caso affermativo la elimina dalla cartella autos
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            if ($auto->delete()) {
                return response()->json(['message' => 'Auto cancellata con successo']);
            } else {
                return response()->json(['message' => 'Errore nella eliminazione auto'], 500);
            }
        } else {
            return response()->json(['message' => 'Auto non trovata'], 404);
        }
    }
    
    /**
     * Ritorna la disponibilità della auto in base alla targa (se trovata) e in base alla data immessa
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function isCarAvailable($targa, $inizio, $fine)
    {
        $available = true;

        $allPrenotazioni = Prenotazione::where('autoTarga', $targa)->get();

        foreach ($allPrenotazioni as $prenotazione) {
            if ($inizio >= $prenotazione->dataInizio
                and $inizio <= $prenotazione->dataFine) {
                //la data di inizio si trova in mezzo al periodo di nolleggio di un altra prenotazione
                $available = false;
            } elseif ($inizio <= $prenotazione->dataInizio and $fine >= $prenotazione->dataInizio) {
                //la data di fine si trova in mezzo al periodo di nolleggio di unaltra prenotazione
                $available = false;
            }
        }
        return $available;
    }
}
