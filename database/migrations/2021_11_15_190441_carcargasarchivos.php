<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Carcargasarchivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carcargasarchivos', function (Blueprint $table) {
            $table->increments('carid');
            $table->unsignedInteger('usuid');
            $table->unsignedInteger('tcaid');
            $table->unsignedInteger('fecid');
            $table->unsignedInteger('empid');
            $table->string('carnombre', 250);
            $table->string('carextension', 5);
            $table->string('carurl', 250);
            $table->boolean('carexito')->default(0);
            $table->timestamps();

            $table->foreign('usuid')->references('usuid')->on('usuusuarios');
            $table->foreign('tcaid')->references('tcaid')->on('tcatiposcargasarchivos');
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
        Schema::dropIfExists('carcargasarchivos');
    }
}
