<?php

namespace Database\Seeders;

use App\Models\tpmtiposmonedas;
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

    }
}
