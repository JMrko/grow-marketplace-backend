<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\pdpproductosdatospaginas;
use App\Models\proproductos;
use Illuminate\Http\Request;

class MetAsignarProductoDeCompetenciaController extends Controller
{
    public function MetObtenerListaCompetencias($pagid)
    {
        $respuesta = false;
        $mensaje   =  '';

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

        $pro = proproductos::where('empid', $empid)
                            ->get([
                                'proid',
                                'prosku',
                                'pronombre'
                            ]);
        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de productos satisfactoriamente';        
                                
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

        $pro = proproductos::where('proid',$proid)
                                ->first([
                                    'prosku',
                                    'empid'
                                ]);
        $dtpu = dtpdatospaginas::where('dtpid',$dtpid)
                            ->update([
                                'dtpskuhomologado'=>$pro->prosku,
                                'proid'           =>$proid
                            ]);

        $pdpc        = new pdpproductosdatospaginas();
        $pdpc->proid = $proid;
        $pdpc->dtpid = $dtpid;
        $pdpc->empid = $pro->empid;
        $pdpc->save();
        
        if ($dtpu == 1) {
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

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtp
        ]);
    }
}
