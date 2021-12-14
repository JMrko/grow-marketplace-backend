<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Audauditorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audauditorias', function (Blueprint $table) {
            $table->increments('audid');
            $table->unsignedInteger('usuid');
            $table->unsignedInteger('tpaid');
            $table->unsignedInteger('fecid');
            $table->unsignedInteger('empid');
            $table->string('audip')->nullable();
            $table->string('audjsonentrada');
            $table->string('audjsonsalida');
            $table->string('auddescripcion');
            $table->string('audaccion');
            $table->string('audruta');
            $table->string('audlog');
            $table->string('audpk');
            $table->string('audtabla')->nullable();
            $table->timestamps();

            $table->foreign('usuid')->references('usuid')->on('usuusuarios');
            $table->foreign('tpaid')->references('tpaid')->on('tpatiposauditorias');
            $table->foreign('fecid')->references('fecid')->on('fecfechas');
            $table->foreign('empid')->references('empid')->on('empempresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audauditorias');
    }
}
