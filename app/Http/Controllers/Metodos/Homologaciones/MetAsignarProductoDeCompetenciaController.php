<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\proproductos;
use Illuminate\Http\Request;

class MetAsignarProductoDeCompetenciaController extends Controller
{
    public function MetObtenerListaCompetencias($pagid)
    {
        $respuesta = false;
        $mensaje   =  '';

        if ($pagid) {
            $dtp = dtpdatospaginas::join('pagpaginas as pag','pag.pagid','dtpdatospaginas.pagid')
                                ->where('dtpdatospaginas.pagid', $pagid)
                                ->where('dtpdatospaginas.proid', null)
                                ->get([
                                    'dtpid',
                                    'pag.pagid',
                                    'pagnombre',
                                    'dtpmarca',
                                    'dtpsku',
                                    'dtpdesclarga'
                                ]);
            $respuesta = true;
            $mensaje   = 'Se obtuvo la lista de competencias satisfactoriamente';
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un ID de Marketplace válido';
        }
        
                                
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtp
        ]);
    }

    public function MetObtenerListaProducto($empid)
    {
        $respuesta = false;
        $mensaje   =  '';

        if ($empid) {
            $pro = proproductos::where('empid', $empid)
                                ->get([
                                    'proid',
                                    'prosku',
                                    'pronombre'
                                ]);
            $respuesta = true;
            $mensaje   = 'Se obtuvo la lista de productos satisfactoriamente';
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un ID de empresa válido';
        }
        
                                
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $pro
        ]);
    }

    public function MetAsignacionProductoCompetencia($dtpid,$proid)
    {
        $respuesta = false;
        $mensaje   =  '';

        if ($dtpid && $proid) {

            $pro = proproductos::where('proid',$proid)->first('prosku');//proid sku
            $dtpu = dtpdatospaginas::where('dtpid',$dtpid)
                                ->update([
                                    'dtpskuhomologado'=>$pro->prosku,
                                    'proid'           =>$proid
                                ]);
            if ($dtpu) {
                $dtp = dtpdatospaginas::join('pagpaginas as pag','pag.pagid','dtpdatospaginas.pagid')
                                        ->where('dtpid',$dtpid) 
                                        ->get([
                                            'dtpid',
                                            'proid',
                                            'pagnombre',
                                            'dtpmarca',
                                            'dtpsku',
                                            'dtpdesclarga',
                                            'dtpskuhomologado'
                                        ]);          
            
                $respuesta = true;
                $mensaje   = 'Se guardo el SKU HML ingresado del producto';
            }else{
                $respuesta = false;
                $mensaje   = 'Error al actualizar SKU';
            }
        }else{
            $respuesta = false;
            $mensaje   = 'No se ingreso un SKU Homologado';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtp
        ]);
    }
}
