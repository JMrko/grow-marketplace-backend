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
        $tpu                = new tputiposusuarios();
        $tpu->tpunombre     = "No definido";
        $tpu->save();
    }
}
