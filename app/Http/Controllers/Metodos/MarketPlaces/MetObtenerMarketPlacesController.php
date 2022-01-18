<?php

namespace App\Http\Controllers\Metodos\MarketPlaces;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pagpaginas;

class MetObtenerMarketPlacesController extends Controller
{
    public function MetObtenerMarketPlaces(Request $request)
    {

        $pags = pagpaginas::get([
            'pagid as id',
            'pagnombre as nombre'
        ]);

        $requestSalida = response()->json([
            'respuesta' => true,
            'datos'     => $pags
        ]);

        return $requestSalida;

    }
}
