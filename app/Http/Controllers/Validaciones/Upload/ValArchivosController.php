<?php

namespace App\Http\Controllers\Validaciones\Upload;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Upload\MetArchivosController;
use App\Models\empempresas;
use Illuminate\Http\Request;

class ValArchivosController extends Controller
{
    public function ValObtenerListaArchivosCargados($empid)
    {
        $emp = empempresas::where('empid', $empid)->first('empid');
        if ($emp) {
            $archivo = new MetArchivosController;
            return $archivo->MetObtenerListaArchivosCargados($empid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válida'
            ]);
        }
    }
}
