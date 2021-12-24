<?php

namespace App\Http\Controllers\Validaciones\CargaArchivos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\CargaArchivos\MetCargaArchivosMLClienteController;
use App\Http\Controllers\Metodos\CargaArchivos\MetCargaArchivosMLCompetenciaController;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ValCargaArchivosController extends Controller
{
    public function ValImportarExcelCliente(Request $request)
    {        
        try {
            $fichero_subido = $request->file('archivo');
            $extension_fichero = IOFactory::identify($fichero_subido);
            if ($extension_fichero == 'Xlsx' || $extension_fichero == 'Xls') {
                $ex_Cliente = new MetCargaArchivosMLClienteController;
                return $ex_Cliente->MetCargaArchivosCliente($request);
            }
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un archivo de extension .xls o .xlsx'
            ]);
        }
    }

    public function ValImportarExcelCompetencia(Request $request)
    {        
        try {
            $fichero_subido = $request->file('archivo');
            $extension_fichero = IOFactory::identify($fichero_subido);
            if ($extension_fichero == 'Xlsx' || $extension_fichero == 'Xls') {
                $ex_Comp = new MetCargaArchivosMLCompetenciaController;
                return $ex_Comp->MetCargaArchivosCompetencia($request);
            }
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un archivo de extension .xls o .xlsx'
            ]);
        }
    }
}
