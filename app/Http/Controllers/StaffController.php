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

    public function getStaffDetails(Request $request)
    {
        $username = $request->input('username');

        $staffMember = User::where('username', $username)
        ->where('role', 'staff') // Add this condition to filter by role
        ->first();

        if ($staffMember) {
            // Return the staff member details as JSON
            return response()->json($staffMember);
        } else {
            // Staff member not found, return a 404 response
            return response()->json(['message' => 'Staff member not found'], 404);
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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
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
        $staffMember->name = $validatedData['name'];
        $staffMember->surname = $validatedData['surname'];
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