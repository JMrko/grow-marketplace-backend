<?php

namespace Database\Seeders;

use App\Models\catcategorias;
use App\Models\empempresas;
use App\Models\proproductos;
use App\Models\tputiposusuarios;
use Illuminate\Database\Seeder;

class empempresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = new empempresas();
        $empresa->empnombre = 'Softys';
        $empresa->save();

        $tipo_usuario = new tputiposusuarios();
        $tipo_usuario->empid = 1;
        $tipo_usuario->tpunombre = 'DEV';
        $tipo_usuario->tpuprivilegio = 'INMORTAL';
        $tipo_usuario->save();

        $cat = new catcategorias();
        $cat->catnombre = 'CAT1';
        $cat->save();
    }
}
