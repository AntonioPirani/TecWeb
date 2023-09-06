<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resources\Messaggi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessaggiController extends Controller
{
    /* public function index()
    {
        //prende lo user id dell'utente loggato
        $userId = auth()->user()->id;

        //Ritorna l'ultimo messaggio dell'utente che ha la risposta dell'admin non vuota
        $latestUserMessageWithAdminResponse = Messaggi::where('userId', $userId)
            ->whereNotNull('adminResponse')
            ->latest()
            ->first();

        //Se trova il messaggio setta la risposta utente e la risposta admin
        if ($latestUserMessageWithAdminResponse) {
            $userMessage = $latestUserMessageWithAdminResponse->userMessage;
            $adminResponse = $latestUserMessageWithAdminResponse->adminResponse;
            //restituisce la vista con le risposte
            return view('messaging', compact('userMessage', 'adminResponse'));
        } 
        //altrimenti non ha trovato nessun messaggio e setta le risposte a no risposta
        else {
            $userMessage = "No risposta";
            $adminResponse = "No risposta";
            //restituisce la vista senza risposte
            return view('messaging', compact('userMessage', 'adminResponse'));
        }
    } */

    public function index()
    {
        $userId = auth()->user()->id;

        // Retrieve all messages sent by the user, ordered by timestamp (latest first)
        $userMessages = Messaggi::where('userId', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('messaging', compact('userMessages'));
    }

    //metodo POST per salvare il messaggio inviato da utente verso admin
    public function sendMessageToAdmin(Request $request)
    {
        $userId = auth()->user()->id;
        $userMessage = $request->input('userMessage');

        // Salva il messaggio inviato dall'utente nel db
        $message = new Messaggi([
            'userId' => $userId,
            'userMessage' => $userMessage,
            'hasResponse' => false, //l'admin deve rispondere
        ]);

        $message->save();

        return redirect()->back()->with('success', 'Messaggio inviato con successo');
    }

    public
    function inboxAdmin(Request $request)
    {
        //seleziona tutti i messaggi ordinati per lid del utente in modo da vedere vicini tutti i messaggi di uno stesso utente
        $inbox = Messaggi::orderBy('userId')->get();
        //se non ci sono messaggi restituisce un mess di errore
        if ($inbox->isEmpty()) {
            return redirect()->back()->with('error', 'Nessun messaggio nel tuo inbox ');
        }
        //restituisce la vista con il vettore dei messaggi
        return view('messaging', ['inbox' => $inbox]);
    }

    public function rispondiAdmin(Request $request)
    {

        //verifica che quando l'admin clicca rispondi o aggiorna risposta, abbia effettivamente inserito un messaggio di testo
        if ($request->isNotFilled('response')) {
            return redirect()->back()->with('error', 'Nessuna risposta inserita');
        }

        //seleziona il messaggio da aggiornare in base all'id e di conseguenza verifica all'interno del IF se esiste, in caso contrario stampa messaggio di errore
        $messaggio = Messaggi::where('id', $request->input('messageId'))->get();
        if ($messaggio->isNotEmpty()) {
            //se arriva qua vuol dire che e' stato trovato il messaggio con id corrispondente e va ad aggiornare o inserire la risposta tramite update
            Messaggi::where('id', $request->input('messageId'))->update(['adminResponse' => $request->input('response'), 'hasResponse' => true]);
        } else {
            return redirect()->back()->with('error', 'Nessun messaggio trovato con l\'ID specificato');
        }
        //seleziona il nome del utente che ha mandato il messaggio per restituirlo nel messaggio di conferma cosi che l'admin sa a chi ha riposto dopo aver inviato la risposta
        $utente = User::select('nome', 'cognome')->where('id', $request->input('userId'))->get();
        return redirect()->route('inboxAdmin')->with('success', 'Risposta inviata correttamente a' . $utente);
    }
}
