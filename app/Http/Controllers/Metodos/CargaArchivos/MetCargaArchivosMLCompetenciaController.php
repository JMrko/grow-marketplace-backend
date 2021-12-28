<?php

namespace App\Http\Controllers\Metodos\CargaArchivos;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\ETL\MetEtlObtenerDatosPaginasController;
use App\Mail\CargaArchivosMail;
use App\Models\carcargasarchivos;
use App\Models\dtpdatospaginas;
use App\Models\pagpaginas;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MetCargaArchivosMLCompetenciaController extends Controller
{
    public function MetCargaArchivosCompetencia(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        $dtpmercadolibre = true;
        $tpmid = 1;
        $tipo_fichero = 'Productos de Mercado Libre Competencia';
        $tcaid = 1;
        $carexito = true;
        $tpaid = 1;
        $audlog = '';
        $audtabla = 'carcargasarchivos';
        $audpk = '';

        $token  = $request->header('token');
        $fichero_subido = $request->file('archivo');
        $nombre_fichero = $fichero_subido->getClientOriginalName();
        $extension_fichero = $fichero_subido->getClientOriginalExtension();
        $url_fichero = "http://127.0.0.1:8000/descargar-fichero-competencia/".$nombre_fichero;

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

        $nombres_paginas = pagpaginas::get(['pagnombre', 'pagid']);
        
        foreach ($nombres_paginas as $pagina) {
            if(stristr($nombre_fichero,$pagina->pagnombre)){
                $pagId = $pagina->pagid;
                break;
            }else{
                $pagId = 18;
            }
        }

        $objPHPExcel    = IOFactory::load($fichero_subido);
        $objPHPExcel->setActiveSheetIndex(0);
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $ETLController = new MetEtlObtenerDatosPaginasController();
        if($ETLController->validarDataPorFecha($pagId, true, true)){
            for ($i=2; $i <= $numRows ; $i++) {
                $ex_dtpidproducto = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $ex_dtpnombre = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $dtpunidadmedida = $ETLController->obtenerUnidadMedida($ex_dtpnombre);
                $ex_dtpurl = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $ex_dtpventaenpesoschilenos = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $ex_dtpventaenunid = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $ex_dtppromediodeventas = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $ex_dtpprecio = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $ex_dtppreciopromedio = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $ex_dtpfulfillment = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $ex_dtpcatalogo = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                $ex_dtpenviogratis = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                $ex_dtpdescuento = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
                $ex_dtpmercadoenvio = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
                $ex_dtptipopublicacion = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
                $ex_dtpestado = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
                $ex_dtpmercadopago = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
                $ex_dtprepublicada = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
                $ex_dtpcondicion = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
                $ex_dtpstock = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();

                $fecid = $ETLController->validarDataPorFecha($pagId);

                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->fecid                   = $fecid;
                $dtpdatospaginas->pagid                   = $pagId;
                $dtpdatospaginas->tpmid                   = $tpmid;
                $dtpdatospaginas->dtpidproducto           = $ex_dtpidproducto;
                $dtpdatospaginas->dtpnombre               = $ex_dtpnombre;
                $dtpdatospaginas->dtpurl                  = $ex_dtpurl;
                $dtpdatospaginas->dtpstock                = $ex_dtpstock;
                $dtpdatospaginas->dtpunidadmedida         = $dtpunidadmedida;
                $dtpdatospaginas->dtpventaenpesoschilenos = $ex_dtpventaenpesoschilenos;
                $dtpdatospaginas->dtpventaenunid          = $ex_dtpventaenunid;
                $dtpdatospaginas->dtppromediodeventas     = $ex_dtppromediodeventas;
                $dtpdatospaginas->dtpprecio               = $ex_dtpprecio;
                $dtpdatospaginas->dtppreciopromedio       = $ex_dtppreciopromedio;
                $dtpdatospaginas->dtpfulfillment          = $ex_dtpfulfillment;
                $dtpdatospaginas->dtpcatalogo             = $ex_dtpcatalogo;
                $dtpdatospaginas->dtpenviogratis          = $ex_dtpenviogratis;
                $dtpdatospaginas->dtpdescuento            = $ex_dtpdescuento;
                $dtpdatospaginas->dtpmercadoenvio         = $ex_dtpmercadoenvio;
                $dtpdatospaginas->dtptipopublicacion      = $ex_dtptipopublicacion;
                $dtpdatospaginas->dtpestado               = $ex_dtpestado;
                $dtpdatospaginas->dtpmercadopago          = $ex_dtpmercadopago;
                $dtpdatospaginas->dtprepublicada          = $ex_dtprepublicada;
                $dtpdatospaginas->dtpcondicion            = $ex_dtpcondicion;
                $dtpdatospaginas->dtpmercadolibre         = $dtpmercadolibre;

                if ($dtpdatospaginas->save()) {
                    $respuesta = true;
                    $mensaje = 'Se almaceno la data correctamente';
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
                    $request->file('archivo')->move('CargaArchivos/Competencia', $nombre_fichero);
                    $respuesta = true;
                    $mensaje = 'Se almaceno la data carga archivos correctamente';
                }else{
                    $respuesta = false;
                    $mensaje = 'Surgio un error al guardar la data carga archivos';
                }
            }
        }

        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);

        if ($respuesta == true) {//false
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token,
                $usu->usuid,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Carga masiva de data de archivo Excel de la competencia',
                'CARGAR DATA',
                '/importar-excel-competencia', 
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

    public function MetDescargarArchivo($nombre_fichero)
    {
        return response()->download("CargaArchivos/Competencia/$nombre_fichero");
    }
}
