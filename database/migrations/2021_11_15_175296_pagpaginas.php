<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pagpaginas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagpaginas', function (Blueprint $table) {
            $table->increments('pagid');
            $table->unsignedInteger('tpmid');
            $table->string('pagnombre', 150);
            $table->string('paglink', 250);
            $table->string('pagimagen',250)->nullable();
            $table->string('pagbordercolor', 30);
            $table->string('pagbackgroundcolor', 30);
            $table->timestamps();

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
        Schema::dropIfExists('pagpaginas');
    }
}
