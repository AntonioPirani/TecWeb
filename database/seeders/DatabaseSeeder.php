<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Resources\Citta;
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
            /*---------------------------tests-------------------------------------*/
            ['nome' => 'Antonio', 'cognome' => 'Pirani', 'email' => 'anto@anto.it', 'username' => 'antoanto',
                'password' => Hash::make('antoanto'), 'role' => 'staff'],
            ['nome' => 'Luca', 'cognome' => 'Sabatini', 'email' => 'luca@luca.it', 'username' => 'lucaluca',
                'password' => Hash::make('lucaluca'), 'role' => 'user'],

            ['nome' => 'Francesco', 'cognome' => 'Virgolini', 'email' => 'fra@virgo.it', 'username' => 'fravirgo',
                'password' => Hash::make('fravirgo'), 'role' => 'user',],

            /*----------------------------------------------official------------------------------*/
            ['nome' => 'Marco', 'cognome' => 'Bezzecchi', 'email' => 'marco@bezzecchi.it', 'username' => 'clieclie',
                'password' => Hash::make('EJLzkprs'), 'role' => 'user'],

            ['nome' => 'Stefano', 'cognome' => 'Guglielmini', 'email' => 'ste@gu.it', 'username' => 'staffstaff',
                'password' => Hash::make('EJLzkprs'), 'role' => 'staff'],

            ['nome' => 'ad', 'cognome' => 'min', 'email' => 'admin@outlook.it', 'username' => 'adminadmin',
                'password' => Hash::make('EJLzkprs'), 'role' => 'admin',]



        ]);

        $data = [
            ['targa' => 'AB123CD', 'modello' => 'Mirage', 'marca' => 'Mitsubishi', 'posti' => 5,
                'prezzoGiornaliero' => 97.50, 'potenza' => 100, 'tipoCambio' => 'manuale', 'optional' => 'bluetooth', 'foto' => 'Mitsubishi_Mirage.jpg'],
            ['targa' => 'CD987RS', 'modello' => 'Versa', 'marca' => 'Nissan', 'posti' => 5,
                'prezzoGiornaliero' => 119.00, 'potenza' => 140, 'tipoCambio' => 'manuale', 'optional' => 'bluetooth', 'foto' => 'Nissan_Versa.jpg'],
            ['targa' => 'DE456FG', 'modello' => 'Corolla', 'marca' => 'Toyota', 'posti' => 5,
                'prezzoGiornaliero' => 111.00, 'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth', 'foto' => 'Toyota_Corolla.jpg'],
            ['targa' => 'EF321AB', 'modello' => 'Leaf', 'marca' => 'Nissan', 'posti' => 5,
                'prezzoGiornaliero' => 131.50, 'potenza' => 120, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth', 'foto' => 'Nissan_Leaf.jpg'],
            ['targa' => 'GH876PQ', 'modello' => 'BMW X3', 'marca' => 'BMW', 'posti' => 5,
                'prezzoGiornaliero' => 204.70, 'potenza' => 100, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, sedili in pelle, guida assisitita', 'foto' => 'BMW_X3.jpg'],
            ['targa' => 'IJ654KL', 'modello' => 'RAV4', 'marca' => 'Toyota', 'posti' => 4,
                'prezzoGiornaliero' => 145.00, 'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, telecamera di retromarcia', 'foto' => 'Toyota_Rav4.jpg'],
            ['targa' => 'KL432IJ', 'modello' => 'Camry', 'marca' => 'Toyota', 'posti' => 7,
                'prezzoGiornaliero' => 130.00, 'potenza' => 160, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'foto' => 'Toyota_Camry.jpg'],
            ['targa' => 'MN098OP', 'modello' => 'Prius', 'marca' => 'Toyota', 'posti' => 5,
                'prezzoGiornaliero' => 112.00, 'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'foto' => 'Toyota_Prius.jpg'],
            ['targa' => 'OP765MN', 'modello' => 'Yaris', 'marca' => 'Toyota', 'posti' => 5,
                'prezzoGiornaliero' => 104.00, 'potenza' => 90, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'foto' => 'Toyota_Yaris.jpg'],
            ['targa' => 'PQ543GH', 'modello' => 'Corolla', 'marca' => 'Toyota', 'posti' => 5,
                'prezzoGiornaliero' => 120.00, 'potenza' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, sensori di prossimita', 'foto' => 'Toyota_Corolla.jpg'],
            ['targa' => 'TR543SI', 'modello' => 'A5Sportback', 'marca' => 'Audi', 'posti' => 5,
                'prezzoGiornaliero' => 170.80, 'potenza' => 150, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, guida assistita, pacchetto sportivo', 'foto' => 'Audi_A5_Sportback.jpg'],
            ['targa' => 'SD02998', 'modello' => 'Portofino', 'marca' => 'Ferrari', 'posti' => 2,
                'prezzoGiornaliero' => 305.00, 'potenza' => 465, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, tettuccio apribile, cerchi in lega', 'foto' => 'Ferrari_Portofino.jpg'],
            ['targa' => 'HF987KK', 'modello' => 'Colorado', 'marca' => 'Chevrolet', 'posti' => 4,
                'prezzoGiornaliero' => 160.40, 'potenza' => 150, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'foto' => 'Chevrolet_Colorado.jpg'],
            ['targa' => 'PO112SD', 'modello' => 'Fortwo', 'marca' => 'Smart', 'posti' => 2,
                'prezzoGiornaliero' => 130.00, 'potenza' => 90, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth', 'foto' => 'Smart_Fortwo.jpg'],
            ['targa' => 'LE299IL', 'modello' => 'ModelX', 'marca' => 'Tesla', 'posti' => 5,
                'prezzoGiornaliero' => 145.00, 'potenza' => 130, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps, guida assistita', 'foto' => 'Tesla_Model_X.jpg']

        ];

        DB::table('auto')->insert($data);

        DB::table('faq')->insert([
            ['domanda' => 'Come posso prenotare un\'auto sul vostro sito?', 'risposta' => 'Per prenotare un\'auto, basta visitare il nostro sito web, inserire le date e il luogo di ritiro e restituzione dell\'auto, quindi selezionare il veicolo desiderato. Segui le istruzioni per completare la prenotazione.'],
            ['domanda' => 'Quali documenti devo presentare al momento del ritiro dell\'auto?', 'risposta' => 'Al momento del ritiro dell\'auto, dovrai presentare la tua patente di guida valida, una carta di credito a tuo nome e una conferma di prenotazione.'],
            ['domanda' => 'È possibile noleggiare un\'auto per un solo giorno?', 'risposta' => 'Sì, offriamo tariffe giornaliere per il noleggio auto. Puoi prenotare un\'auto per il periodo che meglio si adatta alle tue esigenze, che sia un solo giorno o più settimane.'],
            ['domanda' => 'È possibile noleggiare un\'auto e restituirla in una città diversa?', 'risposta' => 'Sì, offriamo opzioni di noleggio con restituzione in una città diversa. Tuttavia, potrebbe essere applicata una tariffa aggiuntiva per questa opzione, nota come "one-way fee".'],
        ]);

        $jsonFile = 'public/italy_cities.json';
        $data = json_decode(file_get_contents($jsonFile), true);

        foreach ($data as $item) {
            (Citta::create($item));
        }
    }
}
