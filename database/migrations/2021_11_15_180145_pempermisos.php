<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pempermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pempermisos', function (Blueprint $table) {
            $table->increments('pemid');
            $table->unsignedInteger('tpeid');
            $table->string('pemnombre', 150);
            $table->string('permdescripcion', 250);
            $table->string('pemslug', 60);
            $table->string('pemruta', 200);
            $table->timestamps();

            $table->foreign('tpeid')->references('tpeid')->on('tpetipospermisos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pempermisos');
    }
}
