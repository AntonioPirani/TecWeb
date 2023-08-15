<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    //unsigned = non negativo, index = creazione indice per velocizzare le ricerche
    {
        Schema::create('auto', function (Blueprint $table) {
            $table->string('targa', 7)->primary();
            $table->string('modello', 10);
            $table->string('marca', 20);
            $table->float('prezzoGiornaliero')->unsigned()->index();    
            $table->bigInteger('numeroPorte')->unsigned()->index();
            //$table->foreign('catId')->references('catId')->on('category');
            $table->string('tipoCambio', 10);
            $table->boolean('bluetooth');
            $table->boolean('gps');
            $table->boolean('disponibilita')->default(false)->index();
            $table->text('foto')->nullable();
            //allestimento? tabella aggiuntiva? oppure generico note
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
}
