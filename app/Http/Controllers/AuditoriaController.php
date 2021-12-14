<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Metodos\ETL\MetEtlObtenerDatosPaginasController;
use App\Models\audauditorias;
use App\Models\fecfechas;
use Illuminate\Http\Request;
use App\Models\usuusuarios;
use DateTime;

class AuditoriaController extends Controller
{
    public function registrarAuditoria(
        $usutoken,
        $usuid,
        $tpaid,
        $audip,//nullable
        $audjsonentrada,
        $audjsonsalida,
        $auddescripcion,
        $audaccion,
        $audruta,
        $audlog,
        $audpk,
        $audtabla        
    )
    {

        $audjsonentrada = json_encode($audjsonentrada);
        $audjsonsalida = json_encode($audjsonsalida);

        $respuesta = false;

        if($usuid == null){
            $usuusuario = usuusuarios::where('usutoken', $usutoken)->first(['usuid']);
            if($usuusuario){
                $usuid = $usuusuario->usuid;
            }else{
                $usuid = null;
            }
        }

        $audauditorias = new audauditorias();
        $audauditorias->usuid           = $usuid;
        $audauditorias->tpaid           = $tpaid;

        $fechaActual = new MetEtlObtenerDatosPaginasController;
        $fecid = $fechaActual->validarDataPorFecha();
        $audauditorias->fecid           = $fecid;

        $empid = usuusuarios::where('usutoken', $usutoken)
                                    ->first(['empid']);
        $audauditorias->empid           = $empid->empid;
        $audauditorias->audip           = $audip;
        if(strlen($audjsonentrada) < 250){
            $audauditorias->audjsonentrada   = $audjsonentrada;
        }else{
            $audauditorias->audjsonentrada   = substr($audjsonentrada, 0, 250);
        }

        if(strlen($audjsonsalida) < 250){
            $audauditorias->audjsonsalida   = $audjsonsalida;
        }else{
            $audauditorias->audjsonsalida   = substr($audjsonsalida, 0, 250);
        }

        $audauditorias->auddescripcion  = $auddescripcion;
        $audauditorias->audaccion       = $audaccion;
        $audauditorias->audruta         = $audruta;
        $audauditorias->audpk           = $audpk;
        $audauditorias->audtabla        = $audtabla;

        $log = json_encode($audlog);
        if(strlen($log) < 250){
            $audauditorias->audlog   = $log;
        }else{
            $audauditorias->audlog   = substr($log, 0, 250);
        }

        if($audauditorias->save()){
            $respuesta = true;
        }else{
            $respuesta = false;
        }
        return $respuesta;
    }
}
