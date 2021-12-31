<?php

namespace App\Http\Controllers\Validaciones\CargaArchivos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\CargaArchivos\MetCargaArchivosMaestraPreciosController;
use App\Http\Controllers\Metodos\CargaArchivos\MetCargaArchivosMaestraProductosController;
use App\Http\Controllers\Metodos\CargaArchivos\MetCargaArchivosMLClienteController;
use App\Http\Controllers\Metodos\CargaArchivos\MetCargaArchivosMLCompetenciaController;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ValCargaArchivosController extends Controller
{
    public function ValImportarExcelCliente(Request $request)
    {   
        $respuesta = false;
        $mensaje = '';

        $token = $request->header('token');
        $usu = usuusuarios::where('usutoken', $token)->first('usuid');
        if ($usu) {
            try {
                $fichero_subido = $request->file('archivo');
                $extension_fichero = IOFactory::identify($fichero_subido);
                if ($extension_fichero == 'Xlsx' || $extension_fichero == 'Xls') {
                    $ex_Cliente = new MetCargaArchivosMLClienteController;
                    return $ex_Cliente->MetCargaArchivosCliente($request);
                }
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $respuesta = false;
                $mensaje = 'Ingrese un archivo de extension .xls o .xlsx';
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

    public function ValImportarExcelCompetencia(Request $request)
    {        
        $respuesta = false;
        $mensaje = '';
        
        $token = $request->header('token');
        $usu = usuusuarios::where('usutoken', $token)->first('usuid');
        if ($usu) {
            try {
                $fichero_subido = $request->file('archivo');
                $extension_fichero = IOFactory::identify($fichero_subido);
                if ($extension_fichero == 'Xlsx' || $extension_fichero == 'Xls') {
                    $ex_Comp = new MetCargaArchivosMLCompetenciaController;
                    return $ex_Comp->MetCargaArchivosCompetencia($request);
                }
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $respuesta = false;
                $mensaje = 'Ingrese un archivo de extension .xls o .xlsx';
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

    public function ValCargaMaestraPrecios(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        
        $token = $request->header('token');
        $usu = usuusuarios::where('usutoken', $token)->first('usuid');
        if ($usu) {
            try {
                $fichero_subido = $request->file('archivo');
                $extension_fichero = IOFactory::identify($fichero_subido);
                if ($extension_fichero == 'Xlsx' || $extension_fichero == 'Xls') {
                    $precios = new MetCargaArchivosMaestraPreciosController;
                    return $precios->MetCargaMaestraPrecios($request);
                }
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $respuesta = false;
                $mensaje = 'Ingrese un archivo de extension .xls o .xlsx';
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

    public function ValCargaMaestraProductos(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        
        $token = $request->header('token');
        $usu = usuusuarios::where('usutoken', $token)->first('usuid');
        if ($usu) {
            try {
                $fichero_subido = $request->file('archivo');
                $extension_fichero = IOFactory::identify($fichero_subido);
                if ($extension_fichero == 'Xlsx' || $extension_fichero == 'Xls') {
                    $prod = new MetCargaArchivosMaestraProductosController;
                    return $prod->MetCargaMaestraProductos($request);
                }
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $respuesta = false;
                $mensaje = 'Ingrese un archivo de extension .xls o .xlsx';
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
}
