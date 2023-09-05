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
            return response()->json(['message' => 'Staff member added successfully']);
        } else {
            // Errore
            Log::error('Failed to add staff member');
            return response()->json(['message' => 'Failed to add staff member'], 500);
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
        // Validate the form data
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Find the staff member by username
        $username = $request->input('username');
        $staffMember = User::where('username', $username)->first();

        if (!$staffMember) {
            return response()->json(['message' => 'Staff member not found'], 404);
        }

        // Update staff member details
        $staffMember->nome = $validatedData['nome'];
        $staffMember->cognome = $validatedData['cognome'];
        $staffMember->email = $validatedData['email'];
        $staffMember->password = bcrypt($validatedData['password']);

        if ($staffMember->save()) {
            // Staff member successfully updated
            return response()->json(['message' => 'Staff member updated successfully']);
        } else {
            // Something went wrong
            return response()->json(['message' => 'Failed to update staff member'], 500);
        }
    }

    public function delete(Request $request)
    {
        $username = $request->input('username');

        $staffMember = User::where('username', $username)->first();

        if ($staffMember) {
            // Delete the staff member
            if ($staffMember->delete()) {
                // Deletion successful
                return response()->json(['message' => 'Staff member deleted successfully']);
            } else {
                // Something went wrong
                return response()->json(['message' => 'Failed to delete staff member'], 500);
            }
        } else {
            // Staff member not found
            return response()->json(['message' => 'Staff member not found'], 404);
        }
    }




}