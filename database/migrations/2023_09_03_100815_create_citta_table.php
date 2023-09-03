<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Citta;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('citta', function (Blueprint $table) {
            $jsonFile = 'public/italy_cities.json';
            $data = json_decode(file_get_contents($jsonFile), true);

            foreach ($data as $item) {
                Citta::create($item);
            $table->id();
            $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citta');
    }
};
