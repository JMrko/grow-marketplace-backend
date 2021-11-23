<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tuptiposusuariospermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuptiposusuariospermisos', function (Blueprint $table) {
            $table->increments('tupid');
            $table->unsignedInteger('pemid');
            $table->unsignedInteger('tpuid');
            $table->timestamps();

            $table->foreign('pemid')->references('pemid')->on('pempermisos');
            $table->foreign('tpuid')->references('tpuid')->on('tputiposusuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tuptiposusuariospermisos');
    }
}
