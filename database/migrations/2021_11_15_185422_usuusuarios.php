<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuusuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuusuarios', function (Blueprint $table) {
            $table->increments('usuid');
            $table->unsignedInteger('tpuid');
            $table->unsignedInteger('perid');
            $table->unsignedInteger('empid');
            $table->string('usuusuario', 150);
            $table->string('usucontrasenia', 250);
            $table->string('usuimagen', 250)->nullable();
            $table->string('usutoken', 60)->nullable();
            $table->string('usucorreo', 50);
            $table->timestamps();

            $table->foreign('tpuid')->references('tpuid')->on('tputiposusuarios');
            $table->foreign('perid')->references('perid')->on('perpersonas');
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
        Schema::dropIfExists('usuusuarios');
    }
}
