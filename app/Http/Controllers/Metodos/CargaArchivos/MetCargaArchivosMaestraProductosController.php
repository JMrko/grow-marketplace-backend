<?php

namespace App\Http\Controllers\Metodos\CargaArchivos;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\ETL\MetEtlObtenerDatosPaginasController;
use App\Mail\CargaArchivosMail;
use App\Models\carcargasarchivos;
use App\Models\proproductos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MetCargaArchivosMaestraProductosController extends Controller
{
    public function MetCargaMaestraProductos(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        $tpmid = 1;
        $empid = 1;
        $tipo_fichero = 'Maestra Productos';
        $tcaid = 1;
        $carexito = true;
        $tpaid = 1;
        $audlog = '';
        $audtabla = 'proproductos';
        $audpk = '';

        $token  = $request->header('token');
        $fichero_subido = $request->file('archivo');
        $nombre_fichero = $fichero_subido->getClientOriginalName();
        $extension_fichero = $fichero_subido->getClientOriginalExtension();
        $url_fichero = env('URL')."/CargaArchivos/MaestraProductos/".$nombre_fichero;

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

            $pro = proproductos::where('prosku',$ex_cod_material)
                                    ->first('proid');
            if ($pro) {
                proproductos::where('proid',$pro->proid)
                                ->update([
                                    'procodsalesorganization'           => $ex_cod_sales_organization,
                                    'prosalesorganization'              => $ex_sales_organization,
                                    'procodbusiness'                    => $ex_cod_business,
                                    'probusiness'                       => $ex_business,
                                    'pronombre'                         => $ex_material,
                                    'procodcategoria'                   => $ex_cod_categoria,
                                    'procategoria'                      => $ex_categoria,
                                    'procodsector'                      => $ex_cod_sector,
                                    'prosector'                         => $ex_sector,
                                    'procodsegmentacion'                => $ex_cod_segmentacion,
                                    'prosegmentacion'                   => $ex_segmentacion,
                                    'procodpresentacion'                => $ex_cod_presentacion,
                                    'propresentacion'                   => $ex_presentacion,
                                    'procodmarca'                       => $ex_cod_marca,
                                    'promarca'                          => $ex_marca,
                                    'procodformato'                     => $ex_cod_formato,
                                    'proformato'                        => $ex_formato,
                                    'procodtalla'                       => $ex_cod_talla,
                                    'protalla'                          => $ex_talla,
                                    'procodconteo'                      => $ex_cod_conteo,
                                    'proconteo'                         => $ex_conteo,
                                    'procodclass9'                      => $ex_cod_class9,
                                    'proclass9'                         => $ex_class9,
                                    'procodclass10'                     => $ex_cod_class10,
                                    'proclass10'                        => $ex_class10,
                                    'propeso'                           => $ex_peso,
                                    'profactorabultos'                  => $ex_factor_a_bultos,
                                    'profactorapaquetes'                => $ex_factor_a_paquetes,
                                    'profactoraunidadminimaindivisible' => $ex_factor_a_unidadMinimaIndivisible,
                                    'profactoratoneladas'               => $ex_factor_a_toneladas,
                                    'profactoramilesdeunidades'         => $ex_factor_a_milesUnidades,
                                    'proattribute7'                     => $ex_attribute7,
                                    'proattribute8'                     => $ex_attribute8,
                                    'proattribute9'                     => $ex_attribute9,
                                    'proattribute10'                    => $ex_attribute10
                                ]);
            }else{
                $ETL = new MetEtlObtenerDatosPaginasController;
                $fecid = $ETL->validarDataPorFecha();

                $proproducto = new proproductos();
                $proproducto->tpmid                             = $tpmid;
                $proproducto->fecid                             = $fecid;
                $proproducto->empid                             = $empid;
                $proproducto->pronombre                         = $ex_material;
                $proproducto->procodsalesorganization           = $ex_cod_sales_organization;
                $proproducto->prosalesorganization              = $ex_sales_organization;
                $proproducto->procodbusiness                    = $ex_cod_business;
                $proproducto->probusiness                       = $ex_business;
                $proproducto->prosku                            = $ex_cod_material;
                $proproducto->procodcategoria                   = $ex_cod_categoria;
                $proproducto->procategoria                      = $ex_categoria;
                $proproducto->procodsector                      = $ex_cod_sector;
                $proproducto->prosector                         = $ex_sector;
                $proproducto->procodsegmentacion                = $ex_cod_segmentacion;
                $proproducto->prosegmentacion                   = $ex_segmentacion;
                $proproducto->procodpresentacion                = $ex_cod_presentacion;
                $proproducto->propresentacion                   = $ex_presentacion;
                $proproducto->procodmarca                       = $ex_cod_marca;
                $proproducto->promarca                          = $ex_marca;
                $proproducto->procodformato                     = $ex_cod_formato;
                $proproducto->proformato                        = $ex_formato;
                $proproducto->procodtalla                       = $ex_cod_talla;
                $proproducto->protalla                          = $ex_talla;
                $proproducto->procodconteo                      = $ex_cod_conteo;
                $proproducto->proconteo                         = $ex_conteo;
                $proproducto->procodclass9                      = $ex_cod_class9;
                $proproducto->proclass9                         = $ex_class9;
                $proproducto->procodclass10                     = $ex_cod_class10;
                $proproducto->proclass10                        = $ex_class10;
                $proproducto->propeso                           = $ex_peso;
                $proproducto->profactorabultos                  = $ex_factor_a_bultos;
                $proproducto->profactorapaquetes                = $ex_factor_a_paquetes;
                $proproducto->profactoraunidadminimaindivisible = $ex_factor_a_unidadMinimaIndivisible;
                $proproducto->profactoratoneladas               = $ex_factor_a_toneladas;
                $proproducto->profactoramilesdeunidades         = $ex_factor_a_milesUnidades;
                $proproducto->proattribute7                     = $ex_attribute7;
                $proproducto->proattribute8                     = $ex_attribute8;
                $proproducto->proattribute9                     = $ex_attribute9;
                $proproducto->proattribute10                    = $ex_attribute10;

                if ($proproducto->save()) {
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
                'Carga masiva de data de archivo Excel de Maestra Productos',
                'CARGAR DATA',
                '/importar-excel-maestra-productos', 
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
