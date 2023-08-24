<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->all());

        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create a new staff member
        $staffMember = new User;
        $staffMember->name = $validatedData['name'];
        $staffMember->surname = $validatedData['surname'];
        $staffMember->username = $validatedData['username'];
        $staffMember->email = $validatedData['email'];
        $staffMember->password = bcrypt($validatedData['password']);
        $staffMember->role = 'staff';
        // Set other fields as needed

        if ($staffMember->save()) {
            // Staff member successfully saved
            Log::info('Staff member added: ' . $staffMember->id);
            return response()->json(['message' => 'Staff member added successfully']);
        } else {
            // Something went wrong
            Log::error('Failed to add staff member');
            return response()->json(['message' => 'Failed to add staff member'], 500);
        }
    }
    
    public function add()
    {
        return view('staff.addstaff');
    }

}
