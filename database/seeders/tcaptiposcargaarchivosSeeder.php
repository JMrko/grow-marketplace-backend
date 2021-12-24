<?php

namespace Database\Seeders;

use App\Models\tcatiposcargasarchivos;
use Illuminate\Database\Seeder;

class tcaptiposcargaarchivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_carga_1 = new tcatiposcargasarchivos();
        $tipo_carga_1->tcanombre = 'Carga de competencia';
        $tipo_carga_1->save();

        $tipo_carga_2 = new tcatiposcargasarchivos();
        $tipo_carga_2->tcanombre = 'Carga de cliente';
        $tipo_carga_2->save();
    }
}
