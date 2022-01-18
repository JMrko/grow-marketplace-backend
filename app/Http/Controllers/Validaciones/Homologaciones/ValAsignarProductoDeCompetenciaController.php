<?php

namespace App\Http\Controllers\Validaciones\Homologaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Homologaciones\MetAsignarProductoDeCompetenciaController;
use App\Models\dtpdatospaginas;
use App\Models\empempresas;
use App\Models\pagpaginas;
use App\Models\proproductos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValAsignarProductoDeCompetenciaController extends Controller
{
    public function ValObtenerListaCompetencias(Request $request)
    {

        $comp = new MetAsignarProductoDeCompetenciaController;
        return $comp->MetObtenerListaCompetencias($request);

        // if($pagid == 0){
        //     $comp = new MetAsignarProductoDeCompetenciaController;
        //     return $comp->MetObtenerListaCompetencias($request);
        // }else{
        //     $pag = pagpaginas::where('pagid', $pagid)->first('pagid');

        //     if ($pag) {
        //         $comp = new MetAsignarProductoDeCompetenciaController;
        //         return $comp->MetObtenerListaCompetencias($request);
        //     }else{
        //         return response()->json([
        //             'respuesta' => false,
        //             'mensaje'   => 'Ingrese un ID de Marketplace válido'
        //         ]);
        //     }
        // }
    }

    public function ValObtenerListaProducto(Request $request)
    {

        $pro = new MetAsignarProductoDeCompetenciaController;
        return $pro->MetObtenerListaProducto($request);

        // $emp = empempresas::where('empid', $empid)->first('empid');

        // if ($emp) {
        //     $pro = new MetAsignarProductoDeCompetenciaController;
        //     return $pro->MetObtenerListaProducto($empid);
        // }else{
        //     return response()->json([
        //         'respuesta' => false,
        //         'mensaje'   => 'Ingrese un ID de empresa válida'
        //     ]);
        // }
    }

    public function ValAsignacionProductoCompetencia(Request $request)
    {
        $respuesta = false;
        $mensaje = '';

        $token = $request->header('api_token');
        $dtpid = $request['dtpid'];
        $proid = $request['proid'];

        $usu = usuusuarios::where('usutoken', $token)->first('usutoken');

        $dtp = dtpdatospaginas::where('dtpid', $dtpid)->first('dtpid');
        $pro = proproductos::where('proid', $proid)->first('proid');
        
        if ($usu) {
            if ($dtp) {
                if ($pro) {
                    $asig = new MetAsignarProductoDeCompetenciaController;
                    return $asig->MetAsignacionProductoCompetencia($request, $dtpid, $proid);
                }else{
                    $respuesta = false;
                    $mensaje = 'Ingrese un ID de producto válido';
                }
            }else{
                $respuesta = false;
                $mensaje = 'Ingrese un ID de datos de página válida';
            }
        }else{
            $respuesta = false;
            $mensaje = 'Ingrese un token valido';
        }
        

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function ValObtenerProductoConHomologaciones(Request $request)
    {
        $respuesta = false;
        $mensaje = '';

        $token = $request->header('token');
        // $usu = usuusuarios::where('usutoken', $token)->first('usutoken');

        // $pro = proproductos::where('proid', $proid)->first('proid');

        // if ($usu) {
        //     if ($pro) {
                $proHomologado = new MetAsignarProductoDeCompetenciaController;
                return $proHomologado->MetObtenerProductoConHomologaciones($request);
            // }else{
            //     $respuesta = false;
            //     $mensaje = 'Ingrese un ID de producto válido';
            // }
        // }else{
        //     $respuesta = false;
        //     $mensaje = 'Ingrese un token valido';
        // }
        
        // return response()->json([
        //     'respuesta' => $respuesta,
        //     'mensaje'   => $mensaje
        // ]);
    }
}
