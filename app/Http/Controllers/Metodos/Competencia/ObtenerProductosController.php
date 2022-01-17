<?php

namespace App\Http\Controllers\Metodos\Competencia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\dtpdatospaginas;

class ObtenerProductosController extends Controller
{
    public function ObtenerProductos(Request $request)
    {

        $dtps = dtpdatospaginas::join('proproductos as pro', 'pro.proid', 'dtpdatospaginas.proid')
                                ->select(
                                    'dtpid',
                                    'dtpprecio',
                                    'dtpdesclarga',
                                    'dtpnombre',
                                    'dtpimagen',
                                    'pro.proid'
                                )
                                ->paginate(18);

        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de competencias satisfactoriamente';
                   
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtps
        ]);

    }
}
