<?php

namespace Database\Seeders;

use App\Models\tpatiposauditorias;
use Illuminate\Database\Seeder;

class tpatiposauditoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoAuditoria1 = new tpatiposauditorias();
        $tipoAuditoria1->tpanombre = "Crear";
        $tipoAuditoria1->save();

        $tipoAuditoria2 = new tpatiposauditorias();
        $tipoAuditoria2->tpanombre = "Editar";
        $tipoAuditoria2->save();

        $tipoAuditoria3 = new tpatiposauditorias();
        $tipoAuditoria3->tpanombre = "Eliminar";
        $tipoAuditoria3->save();

        $tipoAuditoria4 = new tpatiposauditorias();
        $tipoAuditoria4->tpanombre = "Login";
        $tipoAuditoria4->save();

        $tipoAuditoria5 = new tpatiposauditorias();
        $tipoAuditoria5->tpanombre = "Recuperar contraseñia";
        $tipoAuditoria5->save();
    }
}
