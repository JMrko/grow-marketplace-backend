<?php

namespace App\Http\Controllers\Validaciones;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\MetExportarDatosController;
use App\Models\empempresas;
use App\Models\pagpaginas;
use Illuminate\Http\Request;

class ValExportarDatosController extends Controller
{
    public function ValExportarCompetencias($id)
    {
        $pag = pagpaginas::where('pagid', $id)->first('pagid');
        if ($pag) {
            $expComp = new MetExportarDatosController;
            return $expComp->MetExportarCompetencias($id);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de página válida'
            ]);
        }
    }

    public function ValExportarUsuarios($id)
    {
        $emp = empempresas::where('empid', $id)->first('empid');
        if ($emp) {
            $expUsu = new MetExportarDatosController;
            return $expUsu->MetExportarUsuarios($id);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válida'
            ]);
        }
    }

    public function ValExportarProductosEmpresa($id)
    {
        $emp = empempresas::where('empid', $id)->first('empid');
        if ($emp) {
            $expPNH = new MetExportarDatosController;
            return $expPNH->MetExportarProductosEmpresa($id);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válida'
            ]);
        }
    }

    public function ValExportarProductosNoHomologados($pagid)
    {
        $pag = pagpaginas::where('pagid', $pagid)->first('pagid');
        
        if ($pag) {
            $expComp = new MetExportarDatosController;
            return $expComp->MetExportarProductosNoHomologados($pagid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de página válida'
            ]);
        }
    }
}
