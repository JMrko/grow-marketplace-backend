<?php

namespace App\Http\Controllers\Validaciones\Marcas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Metodos\Marcas\MetObtenerMarcasController;

class ValObtenerMarcasController extends Controller
{
    public function ValObtenerMarcas(Request $request)
    {
        $obtMarcas = new MetObtenerMarcasController;
        return $obtMarcas->MetObtenerMarcas($request);
    }
}
