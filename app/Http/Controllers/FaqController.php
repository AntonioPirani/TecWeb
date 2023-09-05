<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Faq;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all(); // Ritorna tutte le FAQs

        return view('faqs', compact('faqs'));
    }

    /**
     * Gestisce la creazione di una nuova faq.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //dd($request->all());  //debug
        $validatedData = $request->validate([
            'domanda' => 'required|string|max:255',
            'risposta' => 'required|string|max:255',
        ]);

        $faq = new Faq;
        $faq->domanda = $validatedData['domanda'];
        $faq->risposta = $validatedData['risposta'];

        if ($faq->save()) {
            Log::info('Nuova FAQ aggiunta: ' . $faq->id);   //Debug nel Log: storage/logs/laravel.log
            return response()->json(['message' => 'Faq aggiunta correttamente']);
        } 

        else {
            Log::error('Failed to add faq');
            return response()->json(['message' => 'Errore nell\'aggiunta della faq'], 500);
        }
    }
    
    public function add()
    {
        return view('faq.addfaq');
    }

    /**
     * Restituisce i dettagli di una faq da cercare tramite id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFaqDetails(Request $request)
    {
        $id = $request->input('id');

        $faq = Faq::where('id', $id)
            ->first();

        if ($faq) {
            return response()->json($faq);
        } else {
            return response()->json(['message' => 'Faq non trovata'], 404);
        }
    }

    public function edit()
    {
        return view('faq.editfaq');
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'domanda' => 'required|string|max:255',
            'risposta' => 'required|string|max:255',
        ]);

        $id = $request->input('id');
        $faq = Faq::where('id', $id)->first();

        if (!$faq) {
            return response()->json(['message' => 'Faq non trovata'], 404);
        }

        $faq->domanda = $validatedData['domanda'];
        $faq->risposta = $validatedData['risposta'];

        if ($faq->save()) {
            return response()->json(['message' => 'Faq aggiornata correttamente']);
        } else {
            return response()->json(['message' => 'Errore nell\'update della faq'], 500);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        $faq = Faq::where('id', $id)->first();

        if ($faq) {
            if ($faq->delete()) {
                return response()->json(['message' => 'Faq eliminata correttamente']);
            } else {
                return response()->json(['message' => 'Errore nella eliminazione della faq'], 500);
            }
        } else {
            return response()->json(['message' => 'Faq non trovata'], 404);
        }
    }

}
