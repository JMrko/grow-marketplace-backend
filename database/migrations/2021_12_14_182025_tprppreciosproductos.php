<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tprppreciosproductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prppreciosproductos', function (Blueprint $table) {
            $table->increments('prpid');
            $table->unsignedInteger('proid');
            $table->unsignedInteger('fecid');
            $table->string('prpprecio', 60);

            $table->foreign('fecid')->references('fecid')->on('fecfechas');
            $table->foreign('proid')->references('proid')->on('proproductos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prppreciosproductos');
    }
}
