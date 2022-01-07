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
            $table->unsignedInteger('tpmid');
            $table->unsignedInteger('tumid')->nullable();
            $table->string('dtpnombre', 250);
            $table->string('dtpprecio', 60);
            $table->string('dtpurl', 350)->nullable(); 
            $table->string('dtpimagen', 250)->nullable();
            $table->string('dtppagina', 150)->nullable();
            $table->string('dtpdesclarga',500)->nullable();
            $table->boolean('dtpsigv')->default(false);
            $table->string('dtpcategoria', 150)->nullable();
            $table->string('dtpsku', 100)->nullable();
            $table->string('dtpskuhomologado', 100)->nullable();
            $table->string('dtpmarca', 150)->nullable();
            $table->string('dtpstock', 100)->nullable();
            $table->string('dtpmecanica', 250)->nullable();
            $table->string('dtpunidadmedida', 250)->nullable();
            $table->boolean('dtpmercadolibre')->default(false);
            $table->string('dtpenviogratis', 25)->nullable();
            $table->string('dtpmercadoenvio', 100)->nullable();
            $table->string('dtpestado', 15)->nullable();//7
            $table->string('dtpexposicion', 15)->nullable();//8
            $table->string('dtpmercadopago', 5)->nullable();//2
            $table->string('dtprepublicada', 5)->nullable();//2
            $table->integer('dtpventaenpesoschilenos')->nullable(); 
            $table->integer('dtpventaenunid')->nullable(); //1-3
            $table->integer('dtpdiaspublicada')->nullable();//3
            $table->decimal('dtpconversion',15,4)->nullable();//16
            $table->decimal('dtpticketpromedio',15,4)->nullable();//15
            $table->decimal('dtppromventaxdia',15,4)->nullable();//5
            $table->integer('dtpvisitaacumulada')->nullable();//5
            $table->string('dtpean', 250)->nullable();
            $table->string('dtpcatalogo', 5)->nullable();//2
            $table->integer('dtpventasenpesoschilenosxperiodo')->nullable();//5
            $table->integer('dtpvisitasxperiodo')->nullable();//1
            $table->integer('dtpventasenunidxperiodo')->nullable();//1
            $table->integer('dtpconversionxperiodo')->nullable();//3
            $table->string('dtpidproducto', 25)->nullable();//12
            $table->decimal('dtppromediodeventas', 15, 4)->nullable();//16
            $table->integer('dtppreciopromedio')->nullable();//5
            $table->string('dtpfulfillment', 5)->nullable();//2
            $table->string('dtpdescuento', 20)->nullable();//2
            $table->string('dtptipopublicacion', 15)->nullable();//8
            $table->string('dtpcondicion', 15)->nullable();//5
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
