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
            $table->unsignedInteger('catid')->nullable();//--
            $table->unsignedInteger('empid')->nullable();//--
            $table->unsignedInteger('fecid')->nullable();
            $table->unsignedInteger('tpmid');
            $table->string('pronombre', 150);
            $table->decimal('proprecio', 15, 4)->nullable(); //debe aceptar 8 decimales
            $table->string('proimagen', 250)->nullable();
            $table->string('prosku', 100)->nullable();
            $table->string('procodsalesorganization', 50)->nullable();
            $table->string('prosalesorganization', 50)->nullable();
            $table->string('procodbusiness', 50)->nullable();
            $table->string('probusiness', 10)->nullable();
            $table->string('procodmaterial', 15)->nullable();
            $table->string('procodcategoria', 20)->nullable();
            $table->string('procategoria', 50)->nullable();
            $table->string('procodsector', 15)->nullable();
            $table->string('prosector', 50)->nullable();
            $table->string('procodsegmentacion', 15)->nullable();
            $table->string('prosegmentacion', 30)->nullable();
            $table->string('procodpresentacion', 15)->nullable();
            $table->string('propresentacion', 30)->nullable();
            $table->string('procodmarca', 15)->nullable();
            $table->string('promarca', 50)->nullable();
            $table->string('procodformato', 15)->nullable();
            $table->string('proformato', 50)->nullable();
            $table->string('procodtalla', 15)->nullable();
            $table->string('protalla', 50)->nullable();
            $table->string('procodconteo', 15)->nullable();
            $table->string('proconteo', 15)->nullable();
            $table->string('procodclass9', 15)->nullable();
            $table->string('proclass9', 15)->nullable();
            $table->string('procodclass10', 15)->nullable();
            $table->string('proclass10', 15)->nullable();
            $table->string('propeso', 15)->nullable();
            $table->integer('profactorabultos')->nullable();
            $table->integer('profactorapaquetes')->nullable();
            $table->integer('profactoraunidadminimaindivisible')->nullable();
            $table->string('profactoratoneladas', 35)->nullable();
            $table->string('profactoramilesdeunidades', 50)->nullable();
            $table->integer('proattribute7')->nullable();
            $table->integer('proattribute8')->nullable();
            $table->integer('proattribute9')->nullable();
            $table->integer('proattribute10')->nullable();
            $table->timestamps();

            $table->foreign('catid')->references('catid')->on('catcategorias');
            $table->foreign('empid')->references('empid')->on('empempresas');
            $table->foreign('fecid')->references('fecid')->on('fecfechas');
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
