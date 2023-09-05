<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{

    public function index() {
        return view('staff');
    }

    public function store(Request $request)
    {
        //dd($request->all());

        //Validazione dei dati immessi tramite form
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'email' => 'required|email|unique:utenti,email',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Nuovo staff
        $staffMember = new User;
        $staffMember->nome = $validatedData['nome'];
        $staffMember->cognome = $validatedData['cognome'];
        $staffMember->username = $validatedData['username'];
        $staffMember->email = $validatedData['email'];
        $staffMember->password = bcrypt($validatedData['password']);
        $staffMember->role = 'staff';

        if ($staffMember->save()) {
            // Successo
            Log::info('Staff member added: ' . $staffMember->id);
            return response()->json(['message' => 'Staff aggiunto con successo']);
        } else {
            // Errore
            Log::error('Failed to add staff member');
            return response()->json(['message' => 'Errore nell\'aggiunta dello staff'], 500);
        }
    }
    
    public function add()
    {
        return view('staff.addstaff');
    }

    public function getStaffDetails(Request $request)
    {
        $username = $request->input('username');

        $staffMember = User::where('username', $username)
        ->where('role', 'staff') // Ritorna solo gli user con ruolo staff
        ->first();

        if ($staffMember) {
            // In formato JSON
            return response()->json($staffMember);
        } else {
            return response()->json(['message' => 'Staff non trovato'], 404);
        }
    }

    public function edit()
    {
        return view('staff.editstaff');
    }

    public function update(Request $request)
    {
        // Validazione dei dati immessi tramite form
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Cerca lo staff con lo username inserito
        $username = $request->input('username');
        $staffMember = User::where('username', $username)->first();

        if (!$staffMember) {
            return response()->json(['message' => 'Staff non trovato'], 404);
        }

        // Aggiorna i dati dello staff
        $staffMember->nome = $validatedData['nome'];
        $staffMember->cognome = $validatedData['cognome'];
        $staffMember->email = $validatedData['email'];
        $staffMember->password = bcrypt($validatedData['password']);

        if ($staffMember->save()) {
            // Successo
            return response()->json(['message' => 'Staff aggiornato con successo']);
        } else {
            // Errore
            return response()->json(['message' => 'Errore nell\'aggiornamento dello staff'], 500);
        }
    }

    public function delete(Request $request)
    {
        $username = $request->input('username');

        $staffMember = User::where('username', $username)->first();

        if ($staffMember) {
            // Staff member trovato
            if ($staffMember->delete()) {
                // Cancella lo staff member
                return response()->json(['message' => 'Staff cancellato correttamente']);
            } else {
                // Errore
                return response()->json(['message' => 'Errore nella eliminazione dello staff'], 500);
            }
        } else {
            // Staff non trovato
            return response()->json(['message' => 'Staff non trovato'], 404);
        }
    }




}