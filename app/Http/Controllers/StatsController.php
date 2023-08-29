<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function monthlyStatistics()
    {
        
        $currentYear = date('Y');

        // Query the "Prenotazioni" table to retrieve rental records for the current year.
        $rentals = DB::table('Prenotazioni')
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
}
