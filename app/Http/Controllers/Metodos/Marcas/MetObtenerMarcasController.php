<?php

namespace App\Http\Controllers\Metodos\Marcas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dtpdatospaginas;

class MetObtenerMarcasController extends Controller
{
    public function MetObtenerMarcas(Request $request)
    {

        $dtps = dtpdatospaginas::distinct('dtpmarca')
                                ->get([
                                    'dtpmarca as nombre'
                                ]);

        $requestSalida = response()->json([
            'respuesta' => true,
            'datos'     => $dtps
        ]);

        return $requestSalida;

    }
}
