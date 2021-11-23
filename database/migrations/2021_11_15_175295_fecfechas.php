<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fecfechas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fecfechas', function (Blueprint $table) {
            $table->increments('fecid');
            $table->date('fecfecha');
            $table->string('fecmesabreviacion');
            $table->integer('fecdianumero');
            $table->integer('fecmesnumero');
            $table->integer('fecanionumero');
            $table->string('fecdiatexto', 10);
            $table->string('fecmestexto', 50);
            $table->string('fecaniotexto', 50)->nullable();
            $table->boolean('fecmesabierto')->default(0);
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
        Schema::dropIfExists('fecfechas');
    }
}
