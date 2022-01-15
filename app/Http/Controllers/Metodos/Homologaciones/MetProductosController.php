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


        // if ($sku) {
            // $pro = proproductos::whereIn('prosku', $sku)
            //                         ->get([
            //                             ''
            //                         ]);
        // }else{
            $pro = dtpdatospaginas::when($sku, function ($query) use ($sku) {
                                            return $query->where('pagid', $sku);
                                        })
                                        ->when($marketplace, function ($query) use ($marketplace) {
                                            return $query->where('dtpprecio', $marketplace);
                                        })
                                        ->when($marca, function ($query) use ($marca) {
                                            return $query->where('dtpprecio', $marca);
                                        })
                                        ->when($categorias, function ($query) use ($categorias) {
                                            return $query->where('dtpprecio', $categorias);
                                        })
                                        ->when($sku, function ($query) use ($sku) {
                                            return $query->where('dtpprecio', $sku);
                                        })
                                        ->when($rango_precios, function ($query) use ($rango_precios) {
                                            return $query->where('dtpprecio', $rango_precios);
                                        })
                                        ->when($descuento, function ($query) use ($descuento) {
                                            return $query->where('dtpprecio', $descuento);
                                        })
                                        ->when($envio_gratis, function ($query) use ($envio_gratis) {
                                            return $query->where('dtpprecio', $envio_gratis);
                                        })
                                        ->when($buscador, function ($query) use ($buscador) {
                                            return $query->where('prpdate','LIKE','%'.$buscador.'%');
                                        })
                                        ->get();
        // }
        

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $pro
        ]);
    }
}
