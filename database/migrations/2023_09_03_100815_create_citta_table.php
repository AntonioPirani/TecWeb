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
        Schema::create('cittas', function (Blueprint $table) {
            $table->id();
            $table->string('istat')->unique();
            $table->string('comune');
            $table->string('regione');
            $table->string('provincia');
            $table->string('prefisso');
            $table->string('cod_fisco');
            $table->double('superficie');
            $table->integer('num_residenti');
            $table->timestamps();
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
