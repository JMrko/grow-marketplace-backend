<?php

namespace Database\Seeders;

use App\Models\tputiposusuarios;
use Illuminate\Database\Seeder;

class tputiposusuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tpu1 = new tputiposusuarios();
        $tpu1->tpunombre     = "Administrador";
        $tpu1->save();

        $tpu2 = new tputiposusuarios();
        $tpu2->tpunombre     = "Cliente";
        $tpu2->save();

        $tpu3 = new tputiposusuarios();
        $tpu3->tpunombre     = "Ejecutivo";
        $tpu3->save();
    }
}
