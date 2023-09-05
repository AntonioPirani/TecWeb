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
        
        $currentYear = date('Y');

        // Query the "Prenotazioni" table to retrieve rental records for the current year.
        $rentals = DB::table('prenotazioni')
            ->select(DB::raw('MONTH(dataInizio) AS month'), DB::raw('COUNT(*) as total'))
            ->whereYear('dataInizio', $currentYear)
            ->groupBy(DB::raw('MONTH(dataInizio)'))
            ->get();

        // Initialize an array to store monthly rental totals.
        $monthlyRentals = [];

        // Create an array with months as keys and total rentals as values.
        foreach ($rentals as $rental) {
            $month = $rental->month;
            $totalRentals = $rental->total;
            $monthlyRentals[$month] = $totalRentals;
        }

        // Loop through the months of the current year and display rental totals.
        for ($month = 1; $month <= 12; $month++) {
            $totalRentals = $monthlyRentals[$month] ?? 0;
            //echo "Month: $month, Total Rentals: $totalRentals\n";
        }

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
        // Check if the 'month' input is present in the request; otherwise, default to the current month.
        $month = $request->input('month', date('n')); // 'n' returns the current month (1-12).

        // Use Eloquent relationships to load user and auto data.
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
