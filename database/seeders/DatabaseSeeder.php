<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    const DESCPROD = '<p>Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum vel, tempor at, varius non, purus. Mauris vitae nisl nec metus placerat consectetuer. Donec ipsum. Proin imperdiet est. Phasellus dapibus semper urna. Pellentesque ornare, orci in consectetuer hendrerit, urna elit eleifend nunc, ut consectetuer nisl felis ac diam. Etiam non felis. Donec ut ante. In id eros. Suspendisse lacus turpis, cursus egestas at sem. Phasellus pellentesque. Mauris quam enim, molestie in, rhoncus ut, lobortis a, est. </p><p>Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum vel, tempor at, varius non, purus. Mauris vitae nisl nec metus placerat consectetuer. Donec ipsum. Proin imperdiet est. Phasellus dapibus semper urna. Pellentesque ornare, orci in consectetuer hendrerit, urna elit eleifend nunc, ut consectetuer nisl felis ac diam. Etiam non felis. Donec ut ante. In id eros. Suspendisse lacus turpis, cursus egestas at sem. Phasellus pellentesque. Mauris quam enim, molestie in, rhoncus ut, lobortis a, est.</p>';

    public function run() {

        DB::table('category')->insert([
            ['catId' => 1, 'name' => 'Computer', 'parId' => 0, 'desc' => 'Desktop, Laptop, Netbook'],
            ['catId' => 2, 'name' => 'Periferiche', 'parId' => 0, 'desc' => 'Hard Disk, Tastiere, Mouse'],
            ['catId' => 3, 'name' => 'Desktop', 'parId' => 1, 'desc' => 'Descrizione dei Prodotti Desktop'],
            ['catId' => 4, 'name' => 'Laptop', 'parId' => 1, 'desc' => 'Descrizione dei Prodotti Laptop'],
            ['catId' => 5, 'name' => 'NetBook', 'parId' => 1, 'desc' => 'Descrizione dei Prodotti Netbook'],
            ['catId' => 6, 'name' => 'HardDisk', 'parId' => 2, 'desc' => 'Descrizione dei Dischi Rigidi'],
        ]);

        DB::table('product')->insert([
            ['name' => 'NetBook Modello2', 'catId' => 5,
                'descShort' => 'Caratteristiche NetBook2', 'descLong' => self::DESCPROD,
                'price' => 219.34, 'discountPerc' => 12, 'discounted' => 0, 'image' => ''],
            ['name' => 'HardDisk Modello2', 'catId' => 6,
                'descShort' => 'Caratteristiche HardDisk2', 'descLong' => self::DESCPROD,
                'price' => 86.37, 'discountPerc' => 15, 'discounted' => 1, 'image' => 'Italy.gif'],
            ['name' => 'Desktop Modello1', 'catId' => 3,
                'descShort' => 'Caratteristiche Desktop1', 'descLong' => self::DESCPROD,
                'price' => 1230.49, 'discountPerc' => 25, 'discounted' => 1, 'image' => 'Brazil.gif'],
            ['name' => 'Laptop Modello1', 'catId' => 4,
                'descShort' => 'Caratteristiche Laptop1', 'descLong' => self::DESCPROD,
                'price' => 455.37, 'discountPerc' => 17, 'discounted' => 1, 'image' => ''],
            ['name' => 'Laptop Modello2', 'catId' => 4,
                'descShort' => 'Caratteristiche Laptop1', 'descLong' => self::DESCPROD,
                'price' => 1889.67, 'discountPerc' => 15, 'discounted' => 1, 'image' => 'Argentina.gif'],
            ['name' => 'Netbook Modello3', 'catId' => 5,
                'descShort' => 'Caratteristiche NetBook3', 'descLong' => self::DESCPROD,
                'price' => 259.99, 'discountPerc' => 17, 'discounted' => 0, 'image' => 'Red Apple.gif'],
            ['name' => 'Laptop Modello3', 'catId' => 4,
                'descShort' => 'Caratteristiche Laptop3', 'descLong' => self::DESCPROD,
                'price' => 998.99, 'discountPerc' => 23, 'discounted' => 1, 'image' => 'UK.gif'],
            ['name' => 'HardDisk Modello1', 'catId' => 6,
                'descShort' => 'Caratteristiche HardDisk1', 'descLong' => self::DESCPROD,
                'price' => 88.93, 'discountPerc' => 5, 'discounted' => 0, 'image' => 'USA.gif'],
            ['name' => 'HardDisk Modello4', 'catId' => 6,
                'descShort' => 'Caratteristiche HardDisk4', 'descLong' => self::DESCPROD,
                'price' => 78.66, 'discountPerc' => 7, 'discounted' => 01, 'image' => 'Ukraine.gif']
        ]);

        DB::table('users')->insert([
            ['name' => 'Alex', 'surname' => 'Verdi', 'email' => 'alex@verdi.it', 'username' => 'alexalex',
                'password' => Hash::make('alexalex'), 'role' => 'user','created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")],
            ['name' => 'Marco', 'surname' => 'Bianchi', 'email' => 'marco@bianchi.it', 'username' => 'useruser',
                'password' => Hash::make('useruser'), 'role' => 'user', 'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")],
            ['name' => 'Mario', 'surname' => 'Rossi', 'email' => 'mario@rossi.it', 'username' => 'adminadmin',
                'password' => Hash::make('adminadmin'), 'role' => 'admin', 'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")]
        ]);

        DB::table('utenti')->insert([
            ['nome' => 'Antonio', 'cognome' => 'Pirani', 'email' => 'anto@anto.it', 'username' => 'antoanto',
                'password' => Hash::make('antoanto'), 'role' => 'user'],
            ['nome' => 'Luca', 'cognome' => 'Sabatini', 'email' => 'luca@luca.it', 'username' => 'lucaluca',
                'password' => Hash::make('lucaluca'), 'role' => 'user'],
            ['nome' => 'Mario', 'cognome' => 'Rossi', 'email' => 'mario@rossi.it', 'username' => 'adminadmin',
                'password' => Hash::make('adminadmin'), 'role' => 'admin',]
        ]);

        $data = [
            ['targa' => 'AB123CD', 'modello' => 'Mirage', 'marca' => 'Mitsubishi', 'prezzoGiornaliero' => 158.50, 'numeroPorte' => 4, 'cilindrata' => 100, 'tipoCambio' => 'manuale', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Mitsubishi_Mirage.jpg'],
            ['targa' => 'CD987RS', 'modello' => 'Versa', 'marca' => 'Nissan', 'prezzoGiornaliero' => 159.00, 'numeroPorte' => 5, 'cilindrata' => 140, 'tipoCambio' => 'manuale', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Nissan_Versa.jpg'],
            ['targa' => 'DE456FG', 'modello' => 'Corolla', 'marca' => 'Toyota', 'prezzoGiornaliero' => 161.00, 'numeroPorte' => 5, 'cilindrata' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Toyota_corolla.jpg'],
            ['targa' => 'EF321AB', 'modello' => 'Leaf', 'marca' => 'Nissan', 'prezzoGiornaliero' => 161.50, 'numeroPorte' => 5, 'cilindrata' => 120, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'Nissan_Leaf.jpg'],
            ['targa' => 'GH876PQ', 'modello' => 'BMW X3', 'marca' => 'BMW', 'prezzoGiornaliero' => 204.70, 'numeroPorte' => 5, 'cilindrata' => 100, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => 'BMW_X3.jpg'],
            ['targa' => 'IJ654KL', 'modello' => 'RAV4', 'marca' => 'Toyota', 'prezzoGiornaliero' => 205.00, 'numeroPorte' => 5, 'cilindrata' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => null],
            ['targa' => 'KL432IJ', 'modello' => 'Camry', 'marca' => 'Toyota', 'prezzoGiornaliero' => 205.00, 'numeroPorte' => 5, 'cilindrata' => 160, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => null],
            ['targa' => 'MN098OP', 'modello' => 'Prius', 'marca' => 'Toyota', 'prezzoGiornaliero' => 205.00, 'numeroPorte' => 5, 'cilindrata' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => null],
            ['targa' => 'OP765MN', 'modello' => 'Yaris', 'marca' => 'Toyota', 'prezzoGiornaliero' => 205.00, 'numeroPorte' => 5, 'cilindrata' => 90, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => null],
            ['targa' => 'PQ543GH', 'modello' => 'Corolla', 'marca' => 'Toyota', 'prezzoGiornaliero' => 205.00, 'numeroPorte' => 5, 'cilindrata' => 110, 'tipoCambio' => 'automatico', 'optional' => 'bluetooth, gps', 'disponibilita' => 1, 'foto' => null]
        ];
        
        DB::table('auto')->insert($data);
}
}