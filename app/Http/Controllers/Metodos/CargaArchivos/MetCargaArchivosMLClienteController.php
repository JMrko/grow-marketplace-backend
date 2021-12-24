<?php

namespace App\Http\Controllers\Metodos\CargaArchivos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\ETL\MetEtlObtenerDatosPaginasController;
use App\Mail\CargaArchivosMail;
use App\Models\dtpdatospaginas;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MetCargaArchivosMLClienteController extends Controller
{
    public function MetCargaArchivosCliente(Request $request)
    {
        $pagId = 17;
        $respuesta = false;
        $mensaje = '';
        $dtpmercadolibre = false;
        $tpmid = 1;
        $tipo_fichero = 'Productos de Mercado Libre Cliente';
 
        $token  = $request->header('token');
        $fichero_subido = $request->file('archivo');
        $nombre_fichero = $fichero_subido->getClientOriginalName();
        $usu = usuusuarios::where('usutoken', $token)
                                ->first([
                                    'usuusuario',
                                    'usucorreo'    
                                ]);
        $data = [
            'usuario' => $usu->usuusuario, 
            'archivo' => $nombre_fichero,
            'tipo'    => $tipo_fichero
        ];

        $objPHPExcel    = IOFactory::load($fichero_subido);
        $objPHPExcel->setActiveSheetIndex(0);
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        $ETLController = new MetEtlObtenerDatosPaginasController();
        if($ETLController->validarDataPorFecha(17, true)){
            for ($i=5; $i <= $numRows ; $i++) {
                $ex_dtpnombre = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $dtpunidadmedida = $ETLController->obtenerUnidadMedida($ex_dtpnombre);
                $ex_dtpidproducto = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $ex_dtpprecio = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $ex_dtpenviogratis = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $ex_dtpmercadoenvio = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $ex_dtpestado = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $ex_dtpexposicion = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $ex_dtpmercadopago = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $ex_dtprepublicada = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                $ex_dtpventaenpesoschilenos = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                $ex_dtpventaenunid = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
                $ex_dtpdiaspublicada = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
                $ex_dtpconversion = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
                $ex_dtpticketpromedio = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
                $ex_dtppromventaxdia = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
                $ex_dtpvisitaacumulada = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
                $ex_dtpean = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
                $ex_dtpcatalogo = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
                $ex_dtpventasenpesoschilenosxperiodo = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
                $ex_dtpvisitasxperiodo = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
                $ex_dtpventasenunidxperiodo = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
                $ex_dtpconversionxperiodo = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
                $ex_dtpsku = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
                $ex_dtpstock = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                
                $fecid = $ETLController->validarDataPorFecha(17);

                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->fecid                            = $fecid;
                $dtpdatospaginas->pagid                            = $pagId;
                $dtpdatospaginas->tpmid                            = $tpmid;
                $dtpdatospaginas->dtpnombre                        = $ex_dtpnombre;
                $dtpdatospaginas->dtpprecio                        = $ex_dtpprecio;
                $dtpdatospaginas->dtpsku                           = $ex_dtpsku;
                $dtpdatospaginas->dtpstock                         = $ex_dtpstock;
                $dtpdatospaginas->dtpunidadmedida                  = $dtpunidadmedida;
                $dtpdatospaginas->dtpidproducto                    = $ex_dtpidproducto;
                $dtpdatospaginas->dtpenviogratis                   = $ex_dtpenviogratis;
                $dtpdatospaginas->dtpmercadoenvio                  = $ex_dtpmercadoenvio;
                $dtpdatospaginas->dtpestado                        = $ex_dtpestado;
                $dtpdatospaginas->dtpexposicion                    = $ex_dtpexposicion;
                $dtpdatospaginas->dtpmercadopago                   = $ex_dtpmercadopago;
                $dtpdatospaginas->dtprepublicada                   = $ex_dtprepublicada;
                $dtpdatospaginas->dtpventaenpesoschilenos          = $ex_dtpventaenpesoschilenos;
                $dtpdatospaginas->dtpventaenunid                   = $ex_dtpventaenunid;
                $dtpdatospaginas->dtpdiaspublicada                 = $ex_dtpdiaspublicada;
                $dtpdatospaginas->dtpconversion                    = $ex_dtpconversion;
                $dtpdatospaginas->dtpticketpromedio                = $ex_dtpticketpromedio;
                $dtpdatospaginas->dtppromventaxdia                 = $ex_dtppromventaxdia;
                $dtpdatospaginas->dtpvisitaacumulada               = $ex_dtpvisitaacumulada;
                $dtpdatospaginas->dtpean                           = $ex_dtpean;
                $dtpdatospaginas->dtpcatalogo                      = $ex_dtpcatalogo;
                $dtpdatospaginas->dtpventasenpesoschilenosxperiodo = $ex_dtpventasenpesoschilenosxperiodo;
                $dtpdatospaginas->dtpvisitasxperiodo               = $ex_dtpvisitasxperiodo;
                $dtpdatospaginas->dtpventasenunidxperiodo          = $ex_dtpventasenunidxperiodo;
                $dtpdatospaginas->dtpconversionxperiodo            = $ex_dtpconversionxperiodo;
                $dtpdatospaginas->dtpmercadolibre                  = $dtpmercadolibre;
                if ($dtpdatospaginas->save()) {
                    $respuesta = true;
                    $mensaje = 'Se almaceno la data correctamente';
                }else{
                    $respuesta = false;
                    $mensaje = 'Surgio un error al guardar la data del excel';
                }
            }
            if ($respuesta == true) {
                Mail::to($usu->usucorreo)->send(new CargaArchivosMail($data));
            }
        }
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }
}