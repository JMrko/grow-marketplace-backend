<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tumtiposunidadesmedidas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tumtiposunidadesmedidas', function (Blueprint $table) {
            $table->increments('tumid');
            $table->string('tumnombre', 150);
            $table->string('tumsigno',5);
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
        Schema::dropIfExists('tumtiposunidadesmedidas');
    }
}
