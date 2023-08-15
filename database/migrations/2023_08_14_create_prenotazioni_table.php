<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrenotazioniTable extends Migration
{
    public function up()
    {
        Schema::create('prenotazioni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('autoTarga', 7);
            $table->date('dataInizio');
            $table->date('dataFine');
            $table->string('statoPrenotazione');
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('utenti');  // TODO rivedere il model 
            $table->foreign('autoTarga')->references('targa')->on('auto');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prenotazioni');
    }
}
