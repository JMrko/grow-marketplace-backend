<?php

namespace App\Http\Controllers\Validaciones\Homologaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Homologaciones\MetAsignarProductoDeCompetenciaController;
use App\Models\dtpdatospaginas;
use App\Models\empempresas;
use App\Models\pagpaginas;
use App\Models\proproductos;
use Illuminate\Http\Request;

class ValAsignarProductoDeCompetenciaController extends Controller
{
    public function ValObtenerListaCompetencias($pagid)
    {
        $pag = pagpaginas::where('pagid', $pagid)->first('pagid');

        if ($pag) {
            $comp = new MetAsignarProductoDeCompetenciaController;
            return $comp->MetObtenerListaCompetencias($pagid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de Marketplace válido'
            ]);
        }
    }

    public function ValObtenerListaProducto($empid)
    {
        $emp = empempresas::where('empid', $empid)->first('empid');

        if ($emp) {
            $pro = new MetAsignarProductoDeCompetenciaController;
            return $pro->MetObtenerListaProducto($empid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válida'
            ]);
        }
    }

    public function ValAsignacionProductoCompetencia($dtpid, $proid)
    {
        $dtp = dtpdatospaginas::where('dtpid', $dtpid)->first('dtpid');
        $pro = proproductos::where('proid', $proid)->first('proid');
        
        if ($dtp) {
            if ($pro) {
                $asig = new MetAsignarProductoDeCompetenciaController;
                return $asig->MetAsignacionProductoCompetencia($dtpid, $proid);
            }else{
                return response()->json([
                    'respuesta' => false,
                    'mensaje'   => 'Ingrese un ID de producto válido'
                ]);
            }
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de datos de página válida'
            ]);
        }
    }
}
