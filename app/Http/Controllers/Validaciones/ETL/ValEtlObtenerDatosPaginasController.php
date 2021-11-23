<?php

namespace App\Http\Controllers\Validaciones\ETL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Metodos\ETL\MetEtlObtenerDatosPaginasController;
use Goutte\Client;

class ValEtlObtenerDatosPaginasController extends Controller
{
    public function ValEtlObtenerDatosPaginas(Client $client)
    {
        $obtenerDatosPaginas = new MetEtlObtenerDatosPaginasController;
        return $obtenerDatosPaginas->MetObtenerArcalauquen($client);
    }
    
}
