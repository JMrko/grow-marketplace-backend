<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tputiposusuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tputiposusuarios', function (Blueprint $table) {
            $table->increments('tpuid');
            $table->unsignedInteger('empid')->nullable();
            $table->string('tpunombre', 150);
            $table->string('tpuprivilegio', 50)->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('tputiposusuarios');
    }
}
