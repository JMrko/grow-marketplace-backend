<?php

namespace Database\Seeders;

use App\Models\pagpaginas;
use Illuminate\Database\Seeder;

class pagpaginasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pagina1 = new pagpaginas();
        $pagina1->tpmid = 1;
        $pagina1->pagnombre = "Grupo Arcalauquen";
        $pagina1->paglink = "https://www.arcalauquen.cl/";
        $pagina1->save();

        $pagina2 = new pagpaginas();
        $pagina2->tpmid = 1;
        $pagina2->pagnombre = "Tork al por mayor";
        $pagina2->paglink = "https://torkalpormayor.cl/";
        $pagina2->save();

        $pagina3 = new pagpaginas();
        $pagina3->tpmid = 1;
        $pagina3->pagnombre = "Dipisa";
        $pagina3->paglink = "https://dipisa.cl/";
        $pagina3->save();

        $pagina4 = new pagpaginas();
        $pagina4->tpmid = 1;
        $pagina4->pagnombre = "Avalco";
        $pagina4->paglink = "https://www.avalco.cl/";
        $pagina4->save();

        $pagina5 = new pagpaginas();
        $pagina5->tpmid = 1;
        $pagina5->pagnombre = "Dilen";
        $pagina5->paglink = "https://dilenchile.cl/";
        $pagina5->save();

        $pagina6 = new pagpaginas();
        $pagina6->tpmid = 1;
        $pagina6->pagnombre = "Sodimac";
        $pagina6->paglink = "https://www.sodimac.cl/";
        $pagina6->save();

        $pagina7 = new pagpaginas();
        $pagina7->tpmid = 1;
        $pagina7->pagnombre = "Distribuidora Pronto";
        $pagina7->paglink = "https://www.dpronto.cl/";
        $pagina7->save();

        $pagina8 = new pagpaginas();
        $pagina8->tpmid = 1;
        $pagina8->pagnombre = "Comcer";
        $pagina8->paglink = "https://www.comcer.cl/";
        $pagina8->save();

        $pagina9 = new pagpaginas();
        $pagina9->tpmid = 1;
        $pagina9->pagnombre = "Ofimaster";
        $pagina9->paglink = "https://www.ofimaster.cl/";
        $pagina9->save();

        $pagina10 = new pagpaginas();
        $pagina10->tpmid = 1;
        $pagina10->pagnombre = "Daos";
        $pagina10->paglink = "https://daos.cl/home/";
        $pagina10->save();

        $pagina11 = new pagpaginas();
        $pagina11->tpmid = 1;
        $pagina11->pagnombre = "Provit";
        $pagina11->paglink = "https://provit.cl/";
        $pagina11->save();

        $pagina12 = new pagpaginas();
        $pagina12->tpmid = 1;
        $pagina12->pagnombre = "LimpiaMas";
        $pagina12->paglink = "https://limpiamas.mercadoshops.cl/";
        $pagina12->save();

        $pagina13 = new pagpaginas();
        $pagina13->tpmid = 1;
        $pagina13->pagnombre = "Hygiene";
        $pagina13->paglink = "https://www.hygiene.cl/";
        $pagina13->save();

        $pagina14 = new pagpaginas();
        $pagina14->tpmid = 1;
        $pagina14->pagnombre = "Central Mayorista";
        $pagina14->paglink = "https://www.centralmayorista.cl/";
        $pagina14->save();

        $pagina15 = new pagpaginas();
        $pagina15->tpmid = 1;
        $pagina15->pagnombre = "Cuponatic";
        $pagina15->paglink = "https://www.cuponatic.com/";
        $pagina15->save();
    }
}
