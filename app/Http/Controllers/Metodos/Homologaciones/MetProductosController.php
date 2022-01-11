<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\proproductos;
use Illuminate\Http\Request;

class MetProductosController extends Controller
{
    public function MetObtenerListaCompletaCompetencia($proid)
    {
        $respuesta = false;
        $mensaje = "";           

        $dtp = dtpdatospaginas::join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                ->where('proid', $proid)
                                ->where('pagprioritario', false)
                                ->get([
                                    'dtpprecio',
                                    'dtpenviogratis',
                                    'dtpdescuento',
                                    'pagimagen',
                                    'dtpurl',
                                ]);

        if ($dtp) {
            $respuesta = true;
            $mensaje = "Se obtuvo la lista completa de competencias";
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtp
        ]);
    }

    public function MetListarProductosFiltros(Request $request)
    {
        $respuesta = false;
        $mensaje = ""; 

        $marketplace   = $request['marketplace'];
        $marca         = $request['marca'];
        $categorias    = $request['categorias'];
        $sku           = $request['sku'];
        $rango_precios = $request['rango_precios'];
        $descuento     = $request['descuento'];
        $envio_gratis  = $request['envio_gratis'];
        $buscador      = $request['buscador'];

        $pro = proproductos::whereIn('', );

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $pro
        ]);
    }
}
