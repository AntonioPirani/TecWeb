<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resources\Messaggi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessaggiController extends Controller
{
    public function index()

    {

        $userId = auth()->user()->id;


        // Find the latest message from the user with an admin response

        $latestUserMessageWithAdminResponse = Messaggi::where('userId', $userId)
            ->whereNotNull('adminResponse')
            ->latest()
            ->first();



        if ($latestUserMessageWithAdminResponse) {

            $userMessage = $latestUserMessageWithAdminResponse->userMessage;

            $adminResponse = $latestUserMessageWithAdminResponse->adminResponse;

            return view('messaging', compact('userMessage', 'adminResponse'));

        } else {

            $userMessage = "No risposta";

            $adminResponse = "No risposta";

            return view('messaging', compact('userMessage', 'adminResponse'));

        }

    }


    public function sendMessageToAdmin(Request $request)

    {

        $userId = auth()->user()->id;

        $userMessage = $request->input('userMessage');


        // Save the user's message to the database

        $message = new Messaggi([

            'userId' => $userId,

            'userMessage' => $userMessage,

            'hasResponse' => false,

        ]);

        $message->save();


        return redirect()->back()->with('success', 'Messaggio inviato con successo');

    }


    public
    function inboxAdmin(Request $request)
    {
        $inbox = Messaggi::all();
//        return $inbox;
        return view('messaging', ['inbox' => $inbox]);
    }

    public
    function rispondiAdmin(Request $request)
    {
        $messaggio = Messaggi::where('id', $request->input('messageId'));
        $messaggio->update('response', $request->input('response'));
        $messaggio->hasResponse = true;
    }
}
