<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\pdpproductosdatospaginas;
use App\Models\proproductos;
use App\Models\usuusuarios;
use App\Models\pagpaginas;
use Illuminate\Http\Request;

class MetAsignarProductoDeCompetenciaController extends Controller
{
    public function MetObtenerListaCompetencias(Request $request)
    {

        $pagsId = $request['pagsid'];
        $marcas = $request['marcas'];

        $respuesta = false;
        $mensaje   =  '';

        $dtp = dtpdatospaginas::join('pagpaginas as pag','pag.pagid','dtpdatospaginas.pagid')
                            // ->where('dtpnombre', 'like', '%elite%')
                            ->where(function ($query) use($pagsId) {
                                if($pagsId == null){
                                    $pagsId = [];
                                }

                                foreach ($pagsId as $key => $pagid) {
                                    $query->orwhere('dtpdatospaginas.pagid', $pagid);   
                                }

                            })
                            ->where(function ($query) use($marcas) {
                                
                                if($marcas == null){
                                    $marcas = [];
                                }

                                foreach ($marcas as $key => $marca) {
                                    $query->orwhere('dtpdatospaginas.dtpmarca', $marca);   
                                }
                            })
                            ->where('dtpdatospaginas.proid', null)
                            // ->limit(20)
                            // ->get([
                                
                            // ])
                            ->select(
                                'dtpid',
                                'pag.pagid',
                                'pagnombre',
                                'dtpmarca',
                                'dtpsku',
                                'dtpdesclarga',
                                'dtpnombre',
                                'dtpimagen'
                            )
                            ->paginate(20);
        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de competencias satisfactoriamente';
                   
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $dtp
        ]);
    }

    public function MetObtenerListaProducto(Request $request)
    {
        $respuesta = false;
        $mensaje   =  '';

        $re_empid = $request['empid'];
        $re_categorias = $request['categorias'];
        $re_subcategorias = $request['subcategorias'];
        $re_txtnombre = $request['txtnombre'];

        $pros = proproductos::where('empid', $re_empid)
                                ->where(function ($query) use($re_categorias) {

                                    foreach ($re_categorias as $key => $categoria) {
                                        $query->orwhere('procategoria', $categoria);   
                                    }

                                })
                                ->where(function ($query) use($re_subcategorias) {

                                    foreach ($re_subcategorias as $key => $subcategoria) {
                                        $query->orwhere('prosector', $subcategoria);
                                    }

                                })
                                ->where(function ($query) use($re_txtnombre) {

                                    if(strlen($re_txtnombre) > 0){
                                        $query->orwhere('pronombre', 'LIKE', "%".$re_txtnombre."%");
                                    }

                                })
                                ->select(
                                    'proid',
                                    'prosku',
                                    'pronombre'
                                )
                                ->paginate(10);

        $categorias = proproductos::distinct('procategoria')
                                    ->get(['procategoria']);

        $subcats = proproductos::distinct('prosector')
                                    ->get(['prosector']);

        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de productos satisfactoriamente';        
                                
        return response()->json([
            'respuesta'  => $respuesta,
            'mensaje'    => $mensaje,
            'datos'      => $pros,
            'categorias' => $categorias,
            'subcats'    => $subcats
        ]);
    }

    public function MetAsignacionProductoCompetencia(Request $request, $dtpid, $proid)
    {
        $respuesta = true;
        $mensaje   = 'Se guardo el SKU HML ingresado del producto';

        $tpaid     = 2;
        $audlog    = '';
        $audtabla  = 'dtpdatospaginas';
        $token     = $request->header('api_token');
        $dtpid     = $request['dtpid'];
        $proid     = $request['proid'];

        $usu = usuusuarios::where('usutoken', $token)
                            ->first('usuid');
                            
        $pro = proproductos::where('proid',$proid)
                                ->first([
                                    'prosku',
                                    'empid'
                                ]);

        $dtp = dtpdatospaginas::find($dtpid);

        $dtps = dtpdatospaginas::where('dtpnombre', $dtp->dtpnombre)
                                // ->where('dtpprecio', $dtp->dtpprecio)
                                ->where('dtpsku', $dtp->dtpsku)
                                ->where('pagid', $dtp->pagid)
                                ->get();

        foreach ($dtps as $key => $dtp) {
            
            $dtpe = dtpdatospaginas::find($dtp->dtpid);
            $dtpe->dtpskuhomologado = $pro->prosku;
            $dtpe->proid = $proid;
            $dtpe->update();

            $pdpc        = new pdpproductosdatospaginas();
            $pdpc->proid = $proid;
            $pdpc->dtpid = $dtp->dtpid;
            $pdpc->empid = $pro->empid;
            $pdpc->save();

        } 

        // $dtpu = dtpdatospaginas::where('dtpid',$dtpid)
        //                     ->update([
        //                         'dtpskuhomologado' =>$pro->prosku ,
        //                         'proid'            =>$proid ,
        //                     ]);

        
        
        // if ($dtpu == 1 && $pdpc->save()) {
            // $dtp = dtpdatospaginas::join('pagpaginas as pag','pag.pagid','dtpdatospaginas.pagid')
            //                         ->where('dtpid',$dtpid) 
            //                         ->get([
            //                             'dtpid',
            //                             'proid',
            //                             'pagnombre',
            //                             'dtpmarca',
            //                             'dtpsku',
            //                             'dtpdesclarga',
            //                             'dtpskuhomologado'
            //                         ]);          
        
            // $respuesta = true;
            // $mensaje   = 'Se guardo el SKU HML ingresado del producto';
        // }else{
        //     $respuesta = false;
        //     $mensaje   = 'Error al actualizar SKU';
        // }

        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            // 'datos'     => $dtp
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

        return $requestSalida;
        
        // return response()->json([
        //     'respuesta' => $respuesta,
        //     'mensaje'   => $mensaje
        // ]);
    }

    public function MetObtenerProductoConHomologaciones(Request $request)
    {
        $respuesta = false;
        $mensaje   =  '';

        $proid = $request['proid'];
        $dtpid = $request['dtpid'];


        // DATO DEL PRODUCTO
        $dtp = dtpdatospaginas::join('proproductos as pro', 'pro.proid', 'dtpdatospaginas.proid')
                            ->where('dtpid', $dtpid)
                            ->first([
                                'pronombre',
                                'dtpnombre',
                                'dtpimagen',
                                'dtpdesclarga',
                                'proprecio'
                            ]);

        // $pags = pagpaginas::where('pagprioritario', true)
        //                     ->get([
        //                         'pagid',
        //                         'pagnombre'
        //                     ]);

        $pags = dtpdatospaginas::join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                ->where('proid', $proid)
                                ->distinct('pag.pagid')
                                ->limit(3)
                                ->get([
                                    'pag.pagid',
                                    'pagnombre',
                                    'pagimagen'
                                ]);
                    
        $listaCompetencias = array();
        $precioBajo = 0;
        $nombrePrecioBajo = "";
                        
        foreach ($pags as $key => $pag) {
            
            $competencia = dtpdatospaginas::join('tpmtiposmonedas as tpm', 'tpm.tpmid', 'dtpdatospaginas.tpmid')
                                        ->join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                        ->join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                        ->where('proid', $proid)
                                        ->where('pag.pagid', $pag->pagid)
                                        ->orderBy('fecfecha', 'DESC')
                                        ->first([
                                            'pagnombre',
                                            'pagimagen',
                                            'paglink',

                                            'dtpprecio',
                                            'dtpurl',
                                            'tpmsigno',

                                            'dtpid',
                                            'dtpenviogratis',
                                            'dtpdescuento',
                                            'proid',
                                            'pag.pagid',

                                            'pagbordercolor',
                                            'pagbackgroundcolor',
                                            'pagcolor'
                                        ]);

            if($competencia){

                if($key == 0){
                    $precioBajo = $competencia->dtpprecio;
                    $nombrePrecioBajo = $competencia->pagnombre;
                }else{
                    if($competencia->dtpprecio < $precioBajo){
                        $precioBajo = $competencia->dtpprecio;
                        $nombrePrecioBajo = $competencia->pagnombre;
                    }
                }

                $listaCompetencias[] = array(
                    "paglink" => $competencia->paglink,
                    "pagnombre" => $competencia->pagnombre,
                    "pagimagen" => $competencia->pagimagen,
                    "dtpprecio" => $competencia->dtpprecio,
                    "dtpurl"    => $competencia->dtpurl,
                    "tpmsigno"  => $competencia->tpmsigno,
                    
                    "dtpid"  => $competencia->dtpid,
                    "dtpenviogratis"  => $competencia->dtpenviogratis,
                    "dtpdescuento"  => $competencia->dtpdescuento,
                    "proid" => $competencia->proid,
                    "pagid" => $competencia->pagid,
                    "esPrecioBajo" => false,

                    "pagbordercolor"     => $competencia->pagbordercolor,
                    "pagbackgroundcolor" => $competencia->pagbackgroundcolor,
                    "pagcolor" => $competencia->pagcolor,
                );
            }
        }

        $primerItemListaCompetencia = array();

        foreach ($listaCompetencias as $key => $competen) {
            
            $primerItemListaCompetencia = $listaCompetencias[0];

            if($competen['pagnombre'] == $nombrePrecioBajo ){
                $listaCompetencias[$key]['esPrecioBajo'] = true;
                $listaCompetencias[0] = $listaCompetencias[$key];
                $listaCompetencias[$key] = $primerItemListaCompetencia;
            }

        }

        $respuesta = true;
        $mensaje = 'Se obtuvo los datos del producto exitosamente';

        return response()->json([
            'respuesta'      => $respuesta,
            'mensaje'        => $mensaje,
            'datos'          => $dtp,
            'competencias'   => $listaCompetencias
        ]);
                    
    }

    public function MetObtenerCompetencias(Request $request)
    {

        $re_paginas = $request['paginas'];
        $proid = $request['proid'];

        $pags = dtpdatospaginas::join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                ->where('proid', $proid)
                                ->where(function ($query) use($re_paginas) {
                                    foreach ($re_paginas as $key => $pagina) {
                                        $query->where('pag.pagid', '!=', $pagina['pagid']);
                                    }
                                })
                                ->distinct('pag.pagid')
                                ->get([
                                    'pag.pagid',
                                    'pagnombre',
                                    'pagimagen'
                                ]);
                            
        $listaCompetencias = array();
        $precioBajo = 0;
        $nombrePrecioBajo = "";
                        
        foreach ($pags as $key => $pag) {
            
            $competencia = dtpdatospaginas::join('tpmtiposmonedas as tpm', 'tpm.tpmid', 'dtpdatospaginas.tpmid')
                                        ->join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                        ->join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                        ->where('proid', $proid)
                                        ->where('pag.pagid', $pag->pagid)
                                        ->orderBy('fecfecha', 'DESC')
                                        ->first([
                                            'pagnombre',
                                            'pagimagen',
                                            'paglink',

                                            'dtpprecio',
                                            'dtpurl',
                                            'tpmsigno',

                                            'dtpid',
                                            'dtpenviogratis',
                                            'dtpdescuento',
                                            'proid',
                                            'pag.pagid',

                                            'pagbordercolor',
                                            'pagbackgroundcolor',
                                            'pagcolor'
                                        ]);

            if($competencia){

                if($key == 0){
                    $precioBajo = $competencia->dtpprecio;
                    $nombrePrecioBajo = $competencia->pagnombre;
                }else{
                    if($competencia->dtpprecio < $precioBajo){
                        $precioBajo = $competencia->dtpprecio;
                        $nombrePrecioBajo = $competencia->pagnombre;
                    }
                }

                $listaCompetencias[] = array(
                    "paglink" => $competencia->paglink,
                    "pagnombre" => $competencia->pagnombre,
                    "pagimagen" => $competencia->pagimagen,
                    "dtpprecio" => $competencia->dtpprecio,
                    "dtpurl"    => $competencia->dtpurl,
                    "tpmsigno"  => $competencia->tpmsigno,
                    
                    "dtpid"  => $competencia->dtpid,
                    "dtpenviogratis"  => $competencia->dtpenviogratis,
                    "dtpdescuento"  => $competencia->dtpdescuento,
                    "proid" => $competencia->proid,
                    "pagid" => $competencia->pagid,
                    "esPrecioBajo" => false,

                    "pagbordercolor"     => $competencia->pagbordercolor,
                    "pagbackgroundcolor" => $competencia->pagbackgroundcolor,
                    "pagcolor" => $competencia->pagcolor,
                );
            }
        }

        $primerItemListaCompetencia = array();

        foreach ($listaCompetencias as $key => $competen) {
            
            $primerItemListaCompetencia = $listaCompetencias[0];

            if($competen['pagnombre'] == $nombrePrecioBajo ){
                $listaCompetencias[$key]['esPrecioBajo'] = true;
                $listaCompetencias[0] = $listaCompetencias[$key];
                $listaCompetencias[$key] = $primerItemListaCompetencia;
            }

        }

        $respuesta = true;
        $mensaje = 'Se obtuvo los datos del producto exitosamente';

        return response()->json([
            'respuesta'      => $respuesta,
            'mensaje'        => $mensaje,
            'competencias'   => $listaCompetencias
        ]);

    }
}
