<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('utenti')->insert([
            ['nome' => 'Antonio', 'cognome' => 'Pirani', 'email' => 'anto@anto.it', 'username' => 'antoanto',
                'password' => Hash::make('antoanto'), 'role' => 'user'],
            ['nome' => 'Luca', 'cognome' => 'Sabatini', 'email' => 'luca@luca.it', 'username' => 'lucaluca',
                'password' => Hash::make('lucaluca'), 'role' => 'user'],
            ['nome' => 'Mario', 'cognome' => 'Rossi', 'email' => 'mario@rossi.it', 'username' => 'adminadmin',
                'password' => Hash::make('adminadmin'), 'role' => 'admin',]
        ]);

        $data = [
            ['targa' => 'AB123CD', 'modello' => 'Mirage', 'marca' => 'Mitsubishi','posti'=>5,
                'prezzoGiornaliero' => 97.50,'potenza' => 100, 'tipoCambio' => 'manuale', 'optional' => 'bluetooth', 'disponibilita' => 1, 'foto' => 'Mitsubishi_Mirage.jpg'],
            ['targa' => 'CD987RS', 'modello' => 'Versa', 'marca' => 'Nissan','posti'=>5,
                'prezzoGiornaliero' => 119.00,'potenza' => 140, 'tipoCambio' => 'manuale', 'optional' => 'bluetooth', 'disponibilita' => 1, 'foto' => 'Nissan_Versa.jpg'],
            ['targa' => 'DE456FG', 'modello' => 'Corolla', 'marca' => 'Toyota','posti'=>5,
                'prezzoGiornaliero' => 111.00,'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth', 'disponibilita' => 1, 'foto' => 'Toyota_Corolla.jpg'],
            ['targa' => 'EF321AB', 'modello' => 'Leaf', 'marca' => 'Nissan','posti'=>5,
                'prezzoGiornaliero' => 131.50, 'potenza' => 120, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth', 'disponibilita' => 1, 'foto' => 'Nissan_Leaf.jpg'],
            ['targa' => 'GH876PQ', 'modello' => 'BMW X3', 'marca' => 'BMW','posti'=>5,
                'prezzoGiornaliero' => 204.70,'potenza' => 100, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, sedili in pelle, guida assisitita', 'disponibilita' => 1, 'foto' => 'BMW_X3.jpg'],
            ['targa' => 'IJ654KL', 'modello' => 'RAV4', 'marca' => 'Toyota','posti'=>4,
                'prezzoGiornaliero' => 145.00, 'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, telecamera di retromarcia', 'disponibilita' => 1, 'foto' => 'Toyota_Rav4.jpg'],
            ['targa' => 'KL432IJ', 'modello' => 'Camry', 'marca' => 'Toyota','posti'=>7,
                'prezzoGiornaliero' => 130.00, 'potenza' => 160, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Toyota_Camry.jpg'],
            ['targa' => 'MN098OP', 'modello' => 'Prius', 'marca' => 'Toyota','posti'=>5,
                'prezzoGiornaliero' => 112.00,'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Toyota_Prius.jpg'],
            ['targa' => 'OP765MN', 'modello' => 'Yaris', 'marca' => 'Toyota','posti'=>5,
                'prezzoGiornaliero' => 104.00,'potenza' => 90, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Toyota_Yaris.jpg'],
            ['targa' => 'PQ543GH', 'modello' => 'Corolla', 'marca' => 'Toyota','posti'=>5,
                'prezzoGiornaliero' => 120.00,'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, sensori di prossimita', 'disponibilita' => 1, 'foto' => 'Toyota_Corolla.jpg'],
            ['targa' => 'TR543SI', 'modello' => 'A5Sportback', 'marca' => 'Audi','posti'=>5,
                'prezzoGiornaliero' => 170.80,'potenza' => 150, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, guida assistita, pacchetto sportivo', 'disponibilita' => 1, 'foto' => 'Audi_A5_Sportback.jpg'],
            ['targa' => 'SD02998', 'modello' => 'Portofino', 'marca' => 'Ferrari','posti'=>2,
                'prezzoGiornaliero' => 305.00,'potenza' => 465, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, tettuccio apribile, cerchi in lega', 'disponibilita' => 1, 'foto' => 'Ferrari_Portofino.jpg'],
            ['targa' => 'HF987KK', 'modello' => 'Colorado', 'marca' => 'Chevrolet','posti'=>4,
            'prezzoGiornaliero' => 160.40, 'potenza' => 150, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Chevrolet_Colorado.jpg'],
            ['targa' => 'PO112SD', 'modello' => 'Fortwo', 'marca' => 'Smart','posti'=>2,
                'prezzoGiornaliero' => 130.00,'potenza' => 90, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth', 'disponibilita' => 1, 'foto' => 'Smart_Fortwo.jpg'],
            ['targa' => 'LE299IL', 'modello' => 'ModelX', 'marca' => 'Tesla','posti'=>5,
                'prezzoGiornaliero' => 1450.00,'potenza' => 130, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, guida assistita', 'disponibilita' => 1, 'foto' => 'Tesla_Model_X.jpg']

        ];

        DB::table('auto')->insert($data);
    }
}
