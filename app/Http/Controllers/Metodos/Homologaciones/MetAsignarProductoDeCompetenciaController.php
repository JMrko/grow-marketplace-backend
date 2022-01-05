<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\pdpproductosdatospaginas;
use App\Models\proproductos;
use App\Models\usuusuarios;
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

    public function MetAsignacionProductoCompetencia(Request $request, $dtpid, $proid)
    {
        $respuesta = false;
        $mensaje   =  '';
        $tpaid = 2;
        $audlog = '';
        $audtabla = 'dtpdatospaginas';

        $token      = $request->header('token');

        $usu = usuusuarios::where('usutoken', $token)
                            ->first('usuid');
                            
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
        // $pdpc->save();
        
        if ($dtpu == 1 && $pdpc->save()) {
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

        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtp
        ]);

        if ($respuesta == true || $respuesta == false) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token,
                $usu->usuid,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Asignacion de producto-cliente a producto de competencia',
                'EDITAR',
                '/asignar-sku/{dtpid}/{proid}', 
                $audlog,
                $dtpid,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Asignacion de producto-cliente y registro de auditoria exitoso';
            }else{
                $respuesta = false;
                $mensaje = 'Error al registrar auditoria';
            }
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function MetObtenerProductoConHomologaciones($proid)
    {
        $respuesta = false;
        $mensaje   =  '';
        
        $pro = proproductos::where('proid', $proid)
                            ->join('tpmtiposmonedas as tpm', 'tpm.tpmid', 'proproductos.tpmid')
                            ->first([
                                'pronombre',
                                'proimagen',
                                'proprecio',
                                'tpmsigno'
                            ]);
        $dtp = dtpdatospaginas::where('proid', $proid)
                                ->join('tpmtiposmonedas as tpm', 'tpm.tpmid', 'dtpdatospaginas.tpmid')
                                ->join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                ->get([
                                    'pagnombre',
                                    'dtpprecio',
                                    'dtpurl',
                                    'tpmsigno'
                                ]);

        if ($pro) {
            $respuesta = true;
            $mensaje = 'Se obtuvo los datos del producto exitosamente';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'  => $pro,
            'homologaciones' => $dtp
        ]);
                    
    }
}
