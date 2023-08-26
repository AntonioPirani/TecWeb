<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
//        if(!Schema::hasTable("prenotazioni")){
            Schema::create('prenotazioni', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('userId')->default(null);
                $table->string('autoTarga', 7)->default(null);
                $table->date('dataInizio');
                $table->date('dataFine');
                $table->string('statoPrenotazione')->default(null);
                $table->foreign('userId')->references('id')->on('utenti');  // TODO rivedere il model
                $table->foreign('autoTarga')->references('targa')->on('auto');
                $table->rememberToken();
                $table->timestamps();
            });
//        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prenotazioni');
    }
};
