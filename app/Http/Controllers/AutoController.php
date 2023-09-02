<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Auto;
use App\Models\Resources\Prenotazione;

class AutoController extends Controller
{
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
            //'disponibilita' => 'required|string|max:255',
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
        //$auto->foto = $validatedData['foto'];

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
            //'disponibilita' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $targa = $request->input('targa');
        $auto = Auto::where('targa', $targa)->first();

        if (!$auto) {
            return response()->json(['message' => 'Auto targa not found'], 404);
        }

        // Check if there's an existing image
        if (!is_null($auto->foto)) {
            $existingImagePath = public_path('images/autos/') . $auto->foto;
            
            // Delete the existing image file from the server
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
        }

        $auto->targa = $validatedData['targa'];
        $auto->modello = $validatedData['modello'];
        $auto->marca = $validatedData['marca'];
        $auto->prezzoGiornaliero = $validatedData['prezzoGiornaliero'];
        $auto->posti = $validatedData['posti'];
        $auto->potenza = $validatedData['potenza'];
        $auto->tipoCambio = $validatedData['tipoCambio'];
        $auto->optional = $validatedData['optional'];
        //$auto->disponibilita = 1;
        
        // Check if 'existingFoto' field exists in the request
        if ($request->has('existingFoto')) {
            // Use the existing image filename
            $auto->foto = $request->input('existingFoto');
        } else {
            // Process the uploaded image as you do for a new image
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $imageName = $image->getClientOriginalName();
                $auto->foto = $imageName;

                $destinationPath = public_path() . '/images/autos';
                $image->move($destinationPath, $imageName);
            } else {
                // Handle the case where no image is provided or needed.
                // You can decide to leave it as is or perform any other actions.
            }
        }

        if ($auto->save()) {
            return response()->json(['message' => 'Auto updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to update auto'], 500);
        }
    }


    public function delete(Request $request)
    {
        $targa = $request->input('targa');
        $auto = Auto::where('targa', $targa)->first();

        if ($auto) {
            // Check if there's an associated image
            if (!is_null($auto->foto)) {
                $existingImagePath = public_path('images/autos/') . $auto->foto;
                
                // Delete the associated image file from the server
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            if ($auto->delete()) {
                return response()->json(['message' => 'Auto deleted successfully']);
            } else {
                return response()->json(['message' => 'Failed to delete auto'], 500);
            }
        } else {
            return response()->json(['message' => 'Auto targa not found'], 404);
        }
    }

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
