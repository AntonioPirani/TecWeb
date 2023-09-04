<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resources\Messaggi;
use App\Models\User;
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
        $inbox = Messaggi::orderBy('userId')->get();
//        return $inbox;
        return view('messaging', ['inbox' => $inbox]);
    }

    public function rispondiAdmin(Request $request)
    {

        if($request->isNotFilled('response')){return redirect()->back()->with('error', 'Nessuna risposta inserita');}
        $messaggio = Messaggi::where('id', $request->input('messageId'))->get();
        if ($messaggio->isNotEmpty()) {
            Messaggi::where('id', $request->input('messageId'))->update(['adminResponse' => $request->input('response'), 'hasResponse' => true]);

        } else {
            return redirect()->back()->with('error', 'Nessun messaggio nel tuo InBox');
        }
        $utente=User::select('nome','cognome')->where('id',$request->input('userId'))->get();
//        $nome=$utente->get('nome');

        return redirect()->route('inboxAdmin')->with('success', 'Risposta inviata correttamente a' . $utente);
    }
}
