<?php

namespace App\Http\Controllers\Validaciones\Administrativo\Permisos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Administrativo\Permisos\MetPermisosController;
use App\Models\tputiposusuarios;
use Illuminate\Http\Request;

class ValPermisosController extends Controller
{
    public function ValObtenerListaPermisos($tpuid)
    {
        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');
        if ($tpu) {
            $per = new MetPermisosController;
            return $per->MetObtenerListaPermisos($tpuid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de tipo de usuario válido'
            ]);
        }
    }
}
