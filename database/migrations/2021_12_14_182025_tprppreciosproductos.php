<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tprppreciosproductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prppreciosproductos', function (Blueprint $table) {
            $table->increments('prpid');
            $table->unsignedInteger('proid')->nullable();
            $table->unsignedInteger('fecid');
            $table->decimal('prpprecio', 15, 4);
            $table->string('prpdate', 15)->nullable();
            $table->integer('prpcodclientesi')->nullable();
            $table->string('prpcodmaterial', 15)->nullable();
            $table->string('prpexchangevalue2', 20)->nullable();
            $table->string('prpexchangevalue3', 20)->nullable();
            $table->string('prpexchangevalue4', 20)->nullable();
            $table->string('prpexchangevalue5', 20)->nullable();
            $table->timestamps();

            $table->foreign('fecid')->references('fecid')->on('fecfechas');
            $table->foreign('proid')->references('proid')->on('proproductos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prppreciosproductos');
    }
}
