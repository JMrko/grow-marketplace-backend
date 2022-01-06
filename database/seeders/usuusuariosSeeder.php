<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\usuusuarios;
use Illuminate\Support\Facades\Hash;

class usuusuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        usuusuarios::create([
            "tpuid"           => 1,
            "perid"           => 1,
            "empid"           => 1,
            "usuusuario"      => "Administrador",
            "usuimagen"       => "/",
            "usucontrasenia"  => Hash::make('Administrador$$'),
            "usutoken"        => "TOKENESPECIFICOUNIFODEVGERSONGROW1845475#LD72",
            "usucorreo"       => "gerson.vilca@grow-analytics.com.pe"
        ]);
    }
}
