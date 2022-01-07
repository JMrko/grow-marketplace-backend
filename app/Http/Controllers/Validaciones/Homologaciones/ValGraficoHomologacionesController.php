<?php

namespace App\Http\Controllers\Validaciones\Homologaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Homologaciones\MetGraficoHomologacionesController;
use App\Models\proproductos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValGraficoHomologacionesController extends Controller
{
    public function ValGrafico(Request $request, $proid)
    {
        $respuesta = false;
        $mensaje = '';

        // $token = $request->header('token');
        // $usu = usuusuarios::where('usutoken', $token)->first('usutoken');

        $pro = proproductos::where('proid', $proid)->first('proid');

        // if ($usu) {
            if ($pro) {
                $grafica = new MetGraficoHomologacionesController;
                return $grafica->MetGrafico($proid);
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
}
