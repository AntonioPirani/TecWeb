<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Resources\Prenotazione;

class StatsController extends Controller
{   
    /**
     * Ritorna il numero totale di auto prenotate per ogni mese. Una auto viene considerata prenotata solo per 
     * il mese in cui inizia la prenotazione.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response 
     */
    public function monthlyStatistics()
    {
        //Prendi l'anno corrente
        $currentYear = date('Y');

        // Esegui la query per ottenere le prenotazioni per ogni mese dell'anno corrente.
        $rentals = DB::table('prenotazioni')
            ->select(DB::raw('MONTH(dataInizio) AS month'), DB::raw('COUNT(*) as total'))
            ->whereYear('dataInizio', $currentYear)
            ->groupBy(DB::raw('MONTH(dataInizio)'))
            ->get();

        // Vettore Prenotazioni totali
        $monthlyRentals = [];

        // associa i valori al vettore e calcola il totale delle prenotazioni per ogni mese
        foreach ($rentals as $rental) {
            $month = $rental->month;
            $totalRentals = $rental->total;
            $monthlyRentals[$month] = $totalRentals;
        }

        // Stampa e salva il numero di prenotazioni per ogni mese
        for ($month = 1; $month <= 12; $month++) {
            $totalRentals = $monthlyRentals[$month] ?? 0;   // ?? 0: se non trova il valore, setta 0
            //echo "Mese: $month, Prenotazioni Totali: $totalRentals\n";
        }

        //ritorna la view con il vettore di dati
        return view('monthly-stats', ['monthlyRentals' => $monthlyRentals]);
    }

    /**
     * A seconda del mese scelto ritorna le auto prenotate in quel mese e l'utente che le ha prenotate. Se c'è uno span
     * tra più mesi, ritorna l'auto in entrambi i mesi (es: Agosto-Settembre) a differenza del metodo sopra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response 
     */
    public function rentalsPerMonth(Request $request)
    {
        // se il mese immesso è presente nella richiesta usa quello, altrimenti usa il mese corrente
        $month = $request->input('month', date('n')); // date('n') restituisce il mese corrente in formato numerico

        // Relazione tra Prenotazione e User e Auto realizzata tramite Eloquent per ritornare le prenotazioni in base alle date inserite
        $prenotazioni = Prenotazione::with('user', 'auto')
            ->where(function ($query) use ($month) {
                $query->whereMonth('dataInizio', $month)
                    ->orWhereMonth('dataFine', $month);
            })
            ->whereYear('dataInizio', date('Y'))
            ->get();

        return view('shared.rentals', compact('prenotazioni', 'month'));
    }

    

}
