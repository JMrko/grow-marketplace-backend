<?php

namespace Database\Seeders;

use App\Models\empempresas;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call(tpmtiposmonedasSeeder::class);
        $this->call(pagpaginasSeeder::class);
        $this->call(tpatiposauditoriasSeeder::class);
        $this->call(tputiposusuariosSeeder::class);
        $this->call(tcaptiposcargaarchivosSeeder::class);
        $this->call(empempresasSeeder::class);
    }
}
