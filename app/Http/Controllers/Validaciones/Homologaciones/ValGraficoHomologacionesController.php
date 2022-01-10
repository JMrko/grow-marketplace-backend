<?php

namespace App\Http\Controllers\Validaciones\Homologaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Homologaciones\MetGraficoHomologacionesController;
use App\Models\pagpaginas;
use App\Models\proproductos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValGraficoHomologacionesController extends Controller
{
    public function ValDatosProductoOriginalGrafico(Request $request, $proid)
    {
        $respuesta = false;
        $mensaje = '';

        // $token = $request->header('token');
        // $usu = usuusuarios::where('usutoken', $token)->first('usutoken');

        $pro = proproductos::where('proid', $proid)->first('proid');

        // if ($usu) {
            if ($pro) {
                $grafica = new MetGraficoHomologacionesController;
                return $grafica->MetDatosProductoOriginalGrafico($proid);
            }else{
                $respuesta = false;
                $mensaje = 'Ingrese un ID de producto válido';
            }
        // }else{
        //     $respuesta = false;
        //     $mensaje = 'Ingrese un token valido';
        // }
        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function ValObtenerProductosCompetenciaGrafico(Request $request)
    {
        $respuesta = false;
        $mensaje = '';

        $pagid = $request['pagid'];
        $proid = $request['proid'];

        $pag = pagpaginas::where('pagid', $pagid)->first(['pagid']);
        $pro = proproductos::where('proid', $proid)->first(['proid']);

        if ($pag) {
            if ($pro) {
                $grafica = new MetGraficoHomologacionesController;
                return $grafica->MetDatosProductosCompetenciaGrafico($request);
            }else{
                $respuesta = false;
                $mensaje   = 'Ingresa un ID de pagina valida';
            }
        }else{
            $respuesta = false;
            $mensaje   = 'Ingresa un ID de pagina valida';
        }
        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }
}
