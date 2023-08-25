<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//        if(!Schema::hasTable("prenotazioni")){
            Schema::create('prenotazioni', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId');
                $table->string('autoTarga', 7);
                $table->date('dataInizio');
                $table->date('dataFine');
                $table->string('statoPrenotazione');
                $table->foreign('userId')->references('id')->on('utenti');  // TODO rivedere il model
                $table->foreign('autoTarga')->references('targa')->on('auto');
            });
//        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenotazioni');
    }
};
