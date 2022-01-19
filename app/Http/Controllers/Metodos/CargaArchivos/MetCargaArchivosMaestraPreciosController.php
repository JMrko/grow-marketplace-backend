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
    public function obtenerFechaExcel($fecha)
    {
        $fechastring = explode("-", $fecha);
        $dia = $fechastring[0];
        $mes = $fechastring[1];
        $anio = $fechastring[2];
        $fecfechaDate = new DateTime($fecha);
        $fechaComoEntero = strtotime($fecha);
        $mesActualAbreviacion = date('M', $fechaComoEntero);
        $mesActualTexto = date("F", $fechaComoEntero);
        $diaActualTexto = date('l', $fechaComoEntero);

        $fecfecha = fecfechas::where('fecdianumero', $dia)
                            ->where('fecmesnumero', $mes)
                            ->where('fecanionumero', $anio)
                            ->first('fecid');
        
        $fecid = 0;
        if ($fecfecha) {
            $fecid = $fecfecha->fecid;
        }else{
            $nuevaFechaActual = new fecfechas();
            $nuevaFechaActual->fecfecha = $fecfechaDate;
            $nuevaFechaActual->fecmesabreviacion = $mesActualAbreviacion;
            $nuevaFechaActual->fecdianumero = $dia;
            $nuevaFechaActual->fecmesnumero = $mes;
            $nuevaFechaActual->fecanionumero = $anio;
            $nuevaFechaActual->fecmestexto = $mesActualTexto;
            $nuevaFechaActual->fecdiatexto = $diaActualTexto;
            if($nuevaFechaActual->save()){
                $fecid = $nuevaFechaActual->fecid;
            }
        }
        return $fecid;

    }
    public function MetCargaMaestraPrecios(Request $request)
    {
        $respuesta    = false;
        $mensaje      = '';
        $tipo_fichero = 'Maestra Precios';
        $tcaid        = 1;
        $carexito     = true;
        $tpaid        = 1;
        $audlog       = '';
        $audtabla     = 'prppreciosproductos';
        $audpk        = '';

        $token  = $request->header('token');
        $fichero_subido = $request->file('archivo');
        $nombre_fichero = $fichero_subido->getClientOriginalName();
        $extension_fichero = $fichero_subido->getClientOriginalExtension();
        $url_fichero = env('URL')."/CargaArchivos/MaestraPrecios/".$nombre_fichero;

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

            if ($i==2) {
                $mes = $fecha_datetime->format('m');
                $dia = $fecha_datetime->format('d');
                $anio = $fecha_datetime->format('Y');
                $fecfechas = fecfechas::where('fecdianumero', $dia)
                                        ->where('fecmesnumero', $mes)
                                        ->where('fecanionumero', $anio)
                                        ->first('fecid');
                
                if ($fecfechas) {
                    prppreciosproductos::where('fecid', $fecfechas->fecid)//buscar con su date en la tabla fecfechas, obtener su fecid y prp eliminar
                                            ->delete();
                }

            }
            
            $proid = proproductos::where('prosku', $ex_codmaterial)->first('proid');
            if ($proid) {
                $proid = $proid->proid;
            }else{
                $proid = null;
            }

            $fecid = $this->obtenerFechaExcel($fecha);

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
                
                $prp = prppreciosproductos::join('fecfechas as fec', 'fec.fecid', 'prppreciosproductos.fecid')
                                    ->where('proid', $proid)
                                    ->orderBy('fecfecha', 'DESC')
                                    ->first([
                                        'proid',
                                        'prpprecio'
                                    ]);
                if ($prp) {
                    proproductos::where('proid', $prp->proid)
                                    ->update([
                                        'proprecio' => $prp->prpprecio
                                    ]);
                }
            }else{
                $respuesta = false;
                $mensaje = 'Surgio un error al guardar la data del excel';
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
                $request->file('archivo')->move('CargaArchivos/MaestraPrecios', $nombre_fichero);
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
