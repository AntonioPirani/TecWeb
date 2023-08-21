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
    public function up()
    {
        Schema::create('auto', function (Blueprint $table) {
            $table->string('targa', 7)->primary();
            $table->string('modello', 10);
            $table->string('marca', 20);
            $table->float('prezzoGiornaliero')->unsigned()->index();    
            $table->bigInteger('numeroPorte')->unsigned()->index();
            $table->bigInteger('cilindrata')->unsigned();
            //$table->foreign('catId')->references('catId')->on('category');
            $table->string('tipoCambio', 10);
            $table->string('optional', 50);
            $table->boolean('disponibilita')->default(false)->index();
            $table->text('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto');
    }
};
