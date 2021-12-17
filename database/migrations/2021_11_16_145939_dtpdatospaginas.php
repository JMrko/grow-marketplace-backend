<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dtpdatospaginas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtpdatospaginas', function (Blueprint $table) {
            $table->increments('dtpid');
            $table->unsignedInteger('pagid');
            $table->unsignedInteger('proid')->nullable();
            $table->unsignedInteger('fecid');
            $table->unsignedInteger('catid')->nullable();
            $table->unsignedInteger('marid')->nullable();
            $table->unsignedInteger('tpmid')->nullable();
            $table->unsignedInteger('tumid')->nullable();
            $table->string('dtpnombre', 250)->nullable();
            $table->string('dtpprecio', 60)->nullable();
            $table->string('dtpurl', 350)->nullable(); 
            $table->string('dtpimagen', 250)->nullable();
            $table->string('dtppagina', 150)->nullable();
            $table->string('dtpdesclarga',500)->nullable();
            $table->string('dtpsigv', 100)->nullable();
            $table->string('dtpcategoria', 150)->nullable();
            $table->string('dtpsku', 100)->nullable();
            $table->string('dtpskuhomologado', 100)->nullable();
            $table->string('dtpmarca', 150)->nullable();
            $table->string('dtpstock', 100)->nullable();
            $table->string('dtpmecanica', 250)->nullable();
            $table->string('dtpunidadmedida', 250)->nullable();
            $table->timestamps();

            $table->foreign('pagid')->references('pagid')->on('pagpaginas');
            $table->foreign('proid')->references('proid')->on('proproductos');
            $table->foreign('fecid')->references('fecid')->on('fecfechas');
            $table->foreign('catid')->references('catid')->on('catcategorias');
            $table->foreign('marid')->references('marid')->on('marmarcas');
            $table->foreign('tpmid')->references('tpmid')->on('tpmtiposmonedas');
            $table->foreign('tumid')->references('tumid')->on('tumtiposunidadesmedidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtpdatospaginas');
    }
}
