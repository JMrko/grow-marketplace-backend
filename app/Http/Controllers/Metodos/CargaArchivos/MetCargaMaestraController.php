<?php

namespace App\Http\Controllers\Metodos\CargaArchivos;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Mail\CargaArchivosMail;
use App\Models\carcargasarchivos;
use App\Models\fecfechas;
use App\Models\proproductos;
use App\Models\usuusuarios;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MetCargaMaestraController extends Controller
{
    public function validarDataMaestraPorFecha($eliminarData=false)
    {
        date_default_timezone_set("America/Lima");
        $fecfechaDate = new DateTime();
        $anioActual = date('Y');
        $mesActual = date('m');
        $diaActual = date('d');
        $mesActualTexto = date('F');
        $diaActualTexto = date('l');
        $mesActualAbreviacion = date('M');

        $fecfecha = fecfechas::where('fecanionumero',$anioActual)
                                ->where('fecmesnumero',$mesActual)
                                ->where('fecdianumero',$diaActual)
                                ->first(['fecid']);
       
        $fecid = 0;
        if ($fecfecha) {
            $fecid = $fecfecha->fecid;
            if($eliminarData == true){       
                proproductos::where('fecid',$fecid)
                                ->delete();
            }
        }else{
            $nuevaFechaActual = new fecfechas();
            $nuevaFechaActual->fecfecha = $fecfechaDate;
            $nuevaFechaActual->fecmesabreviacion = $mesActualAbreviacion;
            $nuevaFechaActual->fecdianumero = $diaActual;
            $nuevaFechaActual->fecmesnumero = $mesActual;
            $nuevaFechaActual->fecanionumero = $anioActual;
            $nuevaFechaActual->fecmestexto = $mesActualTexto;
            $nuevaFechaActual->fecdiatexto = $diaActualTexto;
            if($nuevaFechaActual->save()){
                $fecid = $nuevaFechaActual->fecid;
            }
        }
        return $fecid;
    }
    public function MetCargaMaestra(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        $ex_precio = '';
        $tpmid = 1;
        $tipo_fichero = 'Productos de Mercado Libre Cliente';
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
        if($this->validarDataMaestraPorFecha(true)){
            for ($i=1; $i <= $numRows ; $i++) {
                $ex_cod_sales_organization = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $ex_sales_organization = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $ex_cod_business = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $ex_business = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $ex_cod_material = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $ex_material = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $ex_cod_categoria = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $ex_categoria = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $ex_cod_sector = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $ex_sector = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                $ex_cod_segmentacion = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                $ex_segmentacion = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
                $ex_cod_presentacion = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
                $ex_presentacion = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
                $ex_cod_marca = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
                $ex_marca = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
                $ex_cod_formato = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
                $ex_formato = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
                $ex_cod_talla = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
                $ex_talla = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
                $ex_cod_conteo = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
                $ex_conteo = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
                $ex_cod_class9 = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
                $ex_class9 = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
                $ex_cod_class10 = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
                $ex_class10 = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
                $ex_peso = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
                $ex_factor_a_bultos = $objPHPExcel->getActiveSheet()->getCell('AB'.$i)->getCalculatedValue();
                $ex_factor_a_paquetes = $objPHPExcel->getActiveSheet()->getCell('AC'.$i)->getCalculatedValue();
                $ex_factor_a_unidadMinimaIndivisible = $objPHPExcel->getActiveSheet()->getCell('AD'.$i)->getCalculatedValue();
                $ex_factor_a_toneladas = $objPHPExcel->getActiveSheet()->getCell('AE'.$i)->getCalculatedValue();
                $ex_factor_a_milesUnidades = $objPHPExcel->getActiveSheet()->getCell('AF'.$i)->getCalculatedValue();
                $ex_attribute7 = $objPHPExcel->getActiveSheet()->getCell('AG'.$i)->getCalculatedValue();
                $ex_attribute8 = $objPHPExcel->getActiveSheet()->getCell('AH'.$i)->getCalculatedValue();
                $ex_attribute9 = $objPHPExcel->getActiveSheet()->getCell('AI'.$i)->getCalculatedValue();
                $ex_attribute10 = $objPHPExcel->getActiveSheet()->getCell('AJ'.$i)->getCalculatedValue();

                $fecid = $this->validarDataMaestraPorFecha();

                $proproducto = new proproductos();
                $proproducto->tpmid = $tpmid;
                $proproducto->pronombre = $ex_material;
                $proproducto->proprecio = $ex_precio;
                $proproducto->procodsalesorganization = $ex_cod_sales_organization;
                $proproducto->prosalesorganization = $ex_sales_organization;
                $proproducto->procodbusiness = $ex_cod_business;
                $proproducto->probusiness = $ex_business;
                $proproducto->procodmaterial = $ex_cod_material;
                $proproducto->procodcategoria = $ex_cod_categoria;
                $proproducto->procategoria = $ex_categoria;
                $proproducto->procodsector = $ex_cod_sector;
                $proproducto->prosector = $ex_sector;
                $proproducto->procodsegmentacion = $ex_cod_segmentacion;
                
                if ($proproducto->save()) {
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
                    $request->file('archivo')->move('CargaArchivos/Cliente', $nombre_fichero);
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

        if ($respuesta == true) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token,
                $usu->usuid,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Carga masiva de data de archivo Excel del cliente',
                'CARGAR DATA',
                '/importar-excel-cliente', 
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
