<?php

namespace App\Http\Controllers\Metodos\CargaArchivos;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\ETL\MetEtlObtenerDatosPaginasController;
use App\Mail\CargaArchivosMail;
use App\Models\carcargasarchivos;
use App\Models\fecfechas;
use App\Models\proproductos;
use App\Models\prppreciosproductos;
use App\Models\usuusuarios;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MetCargaArchivosMaestraPreciosController extends Controller
{   
    public function MetCargaMaestraPrecios(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        $tpmid = 1;
        $empid = 1;
        $tipo_fichero = 'Maestra Precios';
        $tcaid = 1;
        $carexito = true;
        $tpaid = 1;
        $audlog = '';
        $audtabla = 'prppreciosproductos';
        $audpk = '';

        $token  = $request->header('token');
        $fichero_subido = $request->file('archivo');
        $nombre_fichero = $fichero_subido->getClientOriginalName();
        $extension_fichero = $fichero_subido->getClientOriginalExtension();
        $url_fichero = "http://127.0.0.1:8000/descargar-fichero-competencia/$nombre_fichero.$extension_fichero";

        $usu = usuusuarios::where('usutoken', $token)
                                ->first([
                                    'usuid',
                                    'usuusuario',
                                    'usucorreo',
                                    'empid'  
                                ]);
                        
        $data = [
            'usuario'     => $usu->usuusuario, 
            'archivo'     => $nombre_fichero,
            'tipo'        => $tipo_fichero,
            'url_archivo' => $url_fichero
        ];

        $objPHPExcel    = IOFactory::load($fichero_subido);
        $objPHPExcel->setActiveSheetIndex(0);
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
      
        for ($i=2; $i <= $numRows ; $i++) {
            $ex_date = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $fecha_datetime = Date::excelToDateTimeObject($ex_date);
            $fecha = $fecha_datetime->format('d-m-Y');
            $ex_codclientesi = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $ex_codmaterial = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $ex_exchangevalue1 = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $ex_exchangevalue2 = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $ex_exchangevalue3 = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $ex_exchangevalue4 = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $ex_exchangevalue5= $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            
            $proid = proproductos::where('procodmaterial', $ex_codmaterial)->first('proid');
            if ($proid) {
                $proid = $proid->proid;
                $prou = proproductos::where('procodmaterial', $ex_codmaterial)
                                        ->update([
                                            'proprecio' => $ex_exchangevalue1
                                        ]);
            }else{
                $proid = null;
            }

            $prp = prppreciosproductos::where('prpcodmaterial',$ex_codmaterial)
                                        ->where('prpdate', $fecha)
                                        ->first('prpid');
            if ($prp) {
                prppreciosproductos::where('prpid',$prp->prpid)
                                    ->update([
                                        'prpprecio'         => $ex_exchangevalue1,
                                        'prpcodclientesi'   => $ex_codclientesi,
                                        'prpexchangevalue2' => $ex_exchangevalue2,
                                        'prpexchangevalue3' => $ex_exchangevalue3,
                                        'prpexchangevalue4' => $ex_exchangevalue4,
                                        'prpexchangevalue5' => $ex_exchangevalue5,
                                    ]);
            }else{
                $ETL = new MetEtlObtenerDatosPaginasController;
                $fecid = $ETL->validarDataPorFecha();

                $prpreciosproductos = new prppreciosproductos();
                $prpreciosproductos->proid                             = $proid;
                $prpreciosproductos->fecid                             = $fecid;
                $prpreciosproductos->prpprecio                         = $ex_exchangevalue1;
                $prpreciosproductos->prpdate                           = $fecha;
                $prpreciosproductos->prpcodclientesi                   = $ex_codclientesi;
                $prpreciosproductos->prpcodmaterial                    = $ex_codmaterial;
                $prpreciosproductos->prpexchangevalue2                 = $ex_exchangevalue2;
                $prpreciosproductos->prpexchangevalue3                 = $ex_exchangevalue3;
                $prpreciosproductos->prpexchangevalue4                 = $ex_exchangevalue4;
                $prpreciosproductos->prpexchangevalue5                 = $ex_exchangevalue5;
    
                if ($prpreciosproductos->save()) {
                    $respuesta = true;
                    $mensaje = 'Se almaceno la data correctamente';
                }else{
                    $respuesta = false;
                    $mensaje = 'Surgio un error al guardar la data del excel';
                }
            }
            
        }
        if ($respuesta == true) {
            $carcargasarchivos = new carcargasarchivos();
            $carcargasarchivos->usuid                 = $usu->usuid;
            $carcargasarchivos->tcaid                 = $tcaid;
            $carcargasarchivos->fecid                 = $fecid;
            $carcargasarchivos->empid                 = $usu->empid;
            $carcargasarchivos->carnombre             = $nombre_fichero;
            $carcargasarchivos->carextension          = $extension_fichero;
            $carcargasarchivos->carurl                = $url_fichero;
            $carcargasarchivos->carexito              = $carexito;

            if ($carcargasarchivos->save()) {
                Mail::to($usu->usucorreo)->send(new CargaArchivosMail($data));
                $request->file('archivo')->move('CargaArchivos/MaestraProductos', $nombre_fichero);
                $respuesta = true;
                $mensaje = 'Se almaceno la data carga archivos correctamente';
            }else{
                $respuesta = false;
                $mensaje = 'Surgio un error al guardar la data carga archivos';
            }
        }
    
        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
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
                'Carga masiva de data de archivo Excel de Maestra Precios',
                'CARGAR DATA',
                '/importar-excel-maestra-precios', 
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Carga de datos y registro de auditoria correctamente';
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
}
