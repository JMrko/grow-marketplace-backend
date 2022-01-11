<?php

namespace App\Http\Controllers\Validaciones\Homologaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Homologaciones\MetProductosController;
use App\Models\proproductos;
use Illuminate\Http\Request;

class ValProductosController extends Controller
{
    public function ValObtenerListaCompletaCompetencia($proid)
    {
        $respuesta = false;
        $mensaje   = "";

        $pro = proproductos::where('proid', $proid)->first('proid');

        if ($pro) {
            $listaProducto = new MetProductosController;
            return $listaProducto->MetObtenerListaCompletaCompetencia($proid);
        }else{
            $respuesta = false;
            $mensaje = "Ingrese un ID de producto valido";
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
        ]);
    }

    public function ValListarProductosFiltros(Request $request)
    {
        $respuesta = false;
        $mensaje   = "";

        $filtro = new MetProductosController;
        return $filtro->MetListarProductosFiltros($request);


        // return response()->json([
        //     'respuesta' => $respuesta,
        //     'mensaje'   => $mensaje,
        // ]);
    }
}
