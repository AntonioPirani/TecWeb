<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Auto;

class AutoController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());

        // Validate the form data
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

        // Create a new staff member
        $auto = new Auto;
        $auto->targa = $validatedData['targa'];
        $auto->modello = $validatedData['modello'];
        $auto->marca = $validatedData['marca'];
        $auto->prezzoGiornaliero = $validatedData['prezzoGiornaliero'];
        $auto->posti = $validatedData['posti'];
        $auto->potenza = $validatedData['potenza'];
        $auto->tipoCambio = $validatedData['tipoCambio'];
        $auto->optional = $validatedData['optional'];
        $auto->disponibilita = 1;
        $auto->foto = $validatedData['foto'];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $file->getClientOriginalName(); // Use the original filename
    
            // Save the file to the public/images/autos directory
            $file->storeAs('public/images/autos', $filename);
        }

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

        $auto = Auto::where('targa', $targa)
        ->first();

        if ($auto) {
            return response()->json($auto);
        } else {
            return response()->json(['message' => 'Auto targa not found'], 404);
        }
    }

    public function edit()
    {
        return view('shared.editauto');
    }

    public function update(Request $request)
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

        $targa = $request->input('targa');
        $auto = Auto::where('targa', $targa)->first();

        if (!$auto) {
            return response()->json(['message' => 'Auto targa not found'], 404);
        }

        // Update staff member details
        $auto->targa = $validatedData['targa'];
        $auto->modello = $validatedData['modello'];
        $auto->marca = $validatedData['marca'];
        $auto->prezzoGiornaliero = $validatedData['prezzoGiornaliero'];
        $auto->posti = $validatedData['posti'];
        $auto->potenza = $validatedData['potenza'];
        $auto->tipoCambio = $validatedData['tipoCambio'];
        $auto->optional = $validatedData['optional'];
        $auto->disponibilita = 1;
        $auto->foto = $validatedData['foto'];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $file->getClientOriginalName(); // Use the original filename
    
            // Save the file to the public/images/autos directory
            $file->storeAs('public/images/autos', $filename);
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
            if ($auto->delete()) {
                return response()->json(['message' => 'Auto deleted successfully']);
            } else {
                return response()->json(['message' => 'Failed to delete auto'], 500);
            }
        } else {
            return response()->json(['message' => 'Auto targa not found'], 404);
        }
    }
}
