<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pdpproductosdatospaginas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdpproductosdatospaginas', function (Blueprint $table) {
            $table->increments('pdpid');
            $table->unsignedInteger('proid')->nullable();
            $table->unsignedInteger('dtpid');
            $table->unsignedInteger('empid');
            $table->timestamps();

            $table->foreign('proid')->references('proid')->on('proproductos');
            $table->foreign('dtpid')->references('dtpid')->on('dtpdatospaginas');
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
        Schema::dropIfExists('pdpproductosdatospaginas');
    }
}
