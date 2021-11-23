<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Proproductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proproductos', function (Blueprint $table) {
            $table->increments('proid');
            $table->unsignedInteger('catid');
            $table->unsignedInteger('empid');
            $table->unsignedInteger('tpmid');
            $table->string('pronombre', 150);
            $table->decimal('proprecio', 15, 8); //debe aceptar 8 decimales
            $table->string('proimagen', 250);
            $table->string('prosku', 100);
            $table->timestamps();

            $table->foreign('catid')->references('catid')->on('catcategorias');
            $table->foreign('empid')->references('empid')->on('empempresas');
            $table->foreign('tpmid')->references('tpmid')->on('tpmtiposmonedas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proproductos');
    }
}
