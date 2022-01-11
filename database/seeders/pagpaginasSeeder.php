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
        $pagina1->tpmid              = 1;
        $pagina1->pagnombre          = "Arcalauquen";
        $pagina1->paglink            = "https://www.arcalauquen.cl/";
        $pagina1->pagbordercolor     = "rgb(222, 39, 39)";
        $pagina1->pagbackgroundcolor = "rgba(222, 39, 39, 0.5)";
        $pagina1->pagprioritario     = true;
        $pagina1->save();

        $pagina2 = new pagpaginas();
        $pagina2->tpmid              = 1;
        $pagina2->pagnombre          = "Tork";
        $pagina2->paglink            = "https://torkalpormayor.cl/";
        $pagina2->pagbordercolor     = "rgb(118, 196, 30)";
        $pagina2->pagbackgroundcolor = "rgba(118, 196, 30, 0.5)";
        $pagina2->pagprioritario     = true;
        $pagina2->save();

        $pagina3 = new pagpaginas();
        $pagina3->tpmid              = 1;
        $pagina3->pagnombre          = "Dipisa";
        $pagina3->paglink            = "https://dipisa.cl/";
        $pagina3->pagbordercolor     = "rgb(36, 133, 68)";
        $pagina3->pagbackgroundcolor = "rgba(36, 133, 68, 0.5)";
        $pagina3->pagprioritario     = true;
        $pagina3->save();

        $pagina4 = new pagpaginas();
        $pagina4->tpmid              = 1;
        $pagina4->pagnombre          = "Avalco";
        $pagina4->paglink            = "https://www.avalco.cl/";
        $pagina4->pagbordercolor     = "rgb(23, 76, 176)";
        $pagina4->pagbackgroundcolor = "rgba(23, 76, 176, 0.5)";
        $pagina4->save();

        $pagina5 = new pagpaginas();
        $pagina5->tpmid              = 1;
        $pagina5->pagnombre          = "Dilen";
        $pagina5->paglink            = "https://dilenchile.cl/";
        $pagina5->pagbordercolor     = "rgb(113, 38, 175)";
        $pagina5->pagbackgroundcolor = "rgba(113, 38, 175, 0.5)";
        $pagina5->save();

        $pagina6 = new pagpaginas();
        $pagina6->tpmid              = 1;
        $pagina6->pagnombre          = "Sodimac";
        $pagina6->paglink            = "https://www.sodimac.cl/";
        $pagina6->pagbordercolor     = "rgb(159, 38, 175)";
        $pagina6->pagbackgroundcolor = "rgba(159, 38, 175, 0.5)";
        $pagina6->save();

        $pagina7 = new pagpaginas();
        $pagina7->tpmid              = 1;
        $pagina7->pagnombre          = "Distribuidora Pronto";
        $pagina7->paglink            = "https://www.dpronto.cl/";
        $pagina7->pagbordercolor     = "rgb(138, 83, 122)";
        $pagina7->pagbackgroundcolor = "rgba(138, 83, 122, 0.5)";
        $pagina7->save();

        $pagina8 = new pagpaginas();
        $pagina8->tpmid              = 1;
        $pagina8->pagnombre          = "Comcer";
        $pagina8->paglink            = "https://www.comcer.cl/";
        $pagina8->pagbordercolor     = "rgb(223, 57, 97)";
        $pagina8->pagbackgroundcolor = "rgba(223, 57, 97, 0.5)";
        $pagina8->save();

        $pagina9 = new pagpaginas();
        $pagina9->tpmid              = 1;
        $pagina9->pagnombre          = "Ofimaster";
        $pagina9->paglink            = "https://www.ofimaster.cl/";
        $pagina9->pagbordercolor     = "rgb(104, 19, 19)";
        $pagina9->pagbackgroundcolor = "rgba(104, 19, 19, 0.5)";
        $pagina9->save();

        $pagina10 = new pagpaginas();
        $pagina10->tpmid              = 1;
        $pagina10->pagnombre          = "Daos";
        $pagina10->paglink            = "https://daos.cl/home/";
        $pagina10->pagbordercolor     = "rgb(103, 112, 69)";
        $pagina10->pagbackgroundcolor = "rgba(103, 112, 69, 0.5)";
        $pagina10->save();

        $pagina11 = new pagpaginas();
        $pagina11->tpmid              = 1;
        $pagina11->pagnombre          = "Provit";
        $pagina11->paglink            = "https://provit.cl/";
        $pagina11->pagbordercolor     = "rgb(211, 207, 200)";
        $pagina11->pagbackgroundcolor = "rgba(211, 207, 200, 0.5)";
        $pagina11->save();

        $pagina12 = new pagpaginas();
        $pagina12->tpmid              = 1;
        $pagina12->pagnombre          = "LimpiaMas";
        $pagina12->paglink            = "https://limpiamas.mercadoshops.cl/";
        $pagina12->pagbordercolor     = "rgb(255, 131, 0)";
        $pagina12->pagbackgroundcolor = "rgba(255, 131, 0, 0.5)";
        $pagina12->save();

        $pagina13 = new pagpaginas();
        $pagina13->tpmid              = 1;
        $pagina13->pagnombre          = "Hygiene";
        $pagina13->paglink            = "https://www.hygiene.cl/";
        $pagina13->pagbordercolor     = "rgb(31, 245, 228)";
        $pagina13->pagbackgroundcolor = "rgba(31, 245, 228, 0.5)";
        $pagina13->save();

        $pagina14 = new pagpaginas();
        $pagina14->tpmid              = 1;
        $pagina14->pagnombre          = "Central Mayorista";
        $pagina14->paglink            = "https://www.centralmayorista.cl/";
        $pagina14->pagbordercolor     = "rgb(117, 156, 203)";
        $pagina14->pagbackgroundcolor = "rgba(117, 156, 203, 0.5)";
        $pagina14->save();

        $pagina15 = new pagpaginas();
        $pagina15->tpmid              = 1;
        $pagina15->pagnombre          = "Cuponatic";
        $pagina15->paglink            = "https://www.cuponatic.com/";
        $pagina15->pagbordercolor     = "rgb(64, 127, 111)";
        $pagina15->pagbackgroundcolor = "rgba(64, 127, 111, 0.5)";
        $pagina15->save();

        $pagina16 = new pagpaginas();
        $pagina16->tpmid              = 1;
        $pagina16->pagnombre          = "Mercado Libre";
        $pagina16->paglink            = "https://www.mercadolibre.cl/";
        $pagina16->pagbordercolor     = "rgb(48, 52, 90)";
        $pagina16->pagbackgroundcolor = "rgba(48, 52, 90, 0.5)";
        $pagina16->save();

        $pagina17 = new pagpaginas();
        $pagina17->tpmid              = 1;
        $pagina17->pagnombre          = "Softys";
        $pagina17->paglink            = "https://www.softys.com/es/";
        $pagina17->pagbordercolor     = "rgb(105, 157, 129)";
        $pagina17->pagbackgroundcolor = "rgba(105, 157, 129, 0.5)";
        $pagina17->save();

        $pagina18 = new pagpaginas();
        $pagina18->tpmid              = 1;
        $pagina18->pagnombre          = "PagOtros";
        $pagina18->paglink            = " ";
        $pagina18->pagbordercolor     = "rgb(128, 58, 101)";
        $pagina18->pagbackgroundcolor = "rgba(128, 58, 101, 0.5)";
        $pagina18->save();
    }
}
