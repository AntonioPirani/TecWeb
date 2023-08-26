<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resources\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all(); // Retrieve all FAQs

        return view('faqs', compact('faqs'));
    }

}
