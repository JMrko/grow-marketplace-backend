<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\perpersonas;

class perpersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        perpersonas::create([
            "pernombrecompleto" => "GERSON VILCA ALVAREZ",
            "pernombre"         => "Gerson",
            "perapellpaterno"   => "Vilca",
            "perapellmaterno"   => "Alvarez",
        ]);
    }
}
