<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Perpersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('perpersonas', function (Blueprint $table) {
            $table->increments('perid');
            $table->string('pernombrecompleto', 250);
            $table->string('pernombre', 150);
            $table->string('perapellpaterno', 150);
            $table->string('perapellmaterno', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perpersonas');
    }
}
