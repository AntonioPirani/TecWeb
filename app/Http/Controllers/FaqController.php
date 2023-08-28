<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Faq;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all(); // Retrieve all FAQs

        return view('faqs', compact('faqs'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'domanda' => 'required|string|max:255',
            'risposta' => 'required|string|max:255',
        ]);

        $faq = new Faq;
        $faq->domanda = $validatedData['domanda'];
        $faq->risposta = $validatedData['risposta'];

        if ($faq->save()) {
            Log::info('New faq added: ' . $faq->id);
            return response()->json(['message' => 'Faq added successfully']);
        } 

        else {
            Log::error('Failed to add faq');
            return response()->json(['message' => 'Failed to add faq'], 500);
        }
    }
    
    public function add()
    {
        return view('faq.addfaq');
    }

    public function getFaqDetails(Request $request)
    {
        $id = $request->input('id');

        $faq = Faq::where('id', $id)
        ->first();

        if ($faq) {
            return response()->json($faq);
        } else {
            return response()->json(['message' => 'Faq not found'], 404);
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
            return response()->json(['message' => 'Faq not found'], 404);
        }

        $faq->domanda = $validatedData['domanda'];
        $faq->risposta = $validatedData['risposta'];

        if ($faq->save()) {
            return response()->json(['message' => 'Faq updated successfully']);
        } else {
            return response()->json(['message' => 'Failed to update faq'], 500);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        $faq = Faq::where('id', $id)->first();

        if ($faq) {
            if ($faq->delete()) {
                return response()->json(['message' => 'Faq deleted successfully']);
            } else {
                return response()->json(['message' => 'Failed to delete faq'], 500);
            }
        } else {
            return response()->json(['message' => 'Faq not found'], 404);
        }
    }

}
