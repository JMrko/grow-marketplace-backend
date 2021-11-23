<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Favfavoritos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favfavoritos', function (Blueprint $table) {
            $table->increments('favid');
            $table->unsignedInteger('usuid');
            $table->string('favnombre', 150);
            $table->string('favurl', 150);
            $table->string('favorden', 150);
            $table->timestamps();

            $table->foreign('usuid')->references('usuid')->on('usuusuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
