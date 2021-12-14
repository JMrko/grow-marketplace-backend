<?php

namespace Database\Seeders;

use App\Models\catcategorias;
use App\Models\empempresas;
use App\Models\perpersonas;
use App\Models\proproductos;
use App\Models\tpmtiposmonedas;
use App\Models\tputiposusuarios;
use Illuminate\Database\Seeder;

class tpmtiposmonedasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moneda1 = new tpmtiposmonedas();
        $moneda1->tpmnombre = "Peso Chileno";
        $moneda1->tpmsigno = "$";
        $moneda1->save();

        $moneda2 = new tpmtiposmonedas();
        $moneda2->tpmnombre = "Dolar";
        $moneda2->tpmsigno = "$";
        $moneda2->save();

        $empresa = new empempresas();
        $empresa->empnombre = 'GROW';
        $empresa->save();

        $tipo_usuario = new tputiposusuarios();
        $tipo_usuario->empid = 1;
        $tipo_usuario->tpunombre = 'DEV';
        $tipo_usuario->tpuprivilegio = 'INMORTAL';
        $tipo_usuario->save();

        $cat = new catcategorias();
        $cat->catnombre = 'CAT1';
        $cat->save();

        $pro = new proproductos();
        $pro->catid = 1;
        $pro->empid = 1;
        $pro->tpmid = 1;
        $pro->pronombre = 'GALLETA';
        $pro->proprecio = '1.2';
        $pro->proimagen = 'IMAGEN';
        $pro->prosku = '151551';
        $pro->save();

        $pro2 = new proproductos();
        $pro2->catid = 1;
        $pro2->empid = 1;
        $pro2->tpmid = 1;
        $pro2->pronombre = 'GALLETA2';
        $pro2->proprecio = '1.22';
        $pro2->proimagen = 'IMAGEN2';
        $pro2->prosku = '1515512';
        $pro2->save();

        $pro3 = new proproductos();
        $pro3->catid = 1;
        $pro3->empid = 1;
        $pro3->tpmid = 1;
        $pro3->pronombre = 'GALLETA3';
        $pro3->proprecio = '1.23';
        $pro3->proimagen = 'IMAGEN3';
        $pro3->prosku = '1515513';
        $pro3->save();

    }
}
