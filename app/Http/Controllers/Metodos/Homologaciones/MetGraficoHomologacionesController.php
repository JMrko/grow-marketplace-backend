<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\pagpaginas;
use App\Models\prppreciosproductos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MetGraficoHomologacionesController extends Controller
{
    public function MetDatosProductoOriginalGrafico(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        $labels_fechas = [];
        $data_grafico = [];
        $arr_data_grafico = array(
            "label"           => "SOFTYS",
            "data"            => [],
            "borderColor"     => "rgb(255, 99, 132)",
            "backgroundColor" => "rgba(255, 99, 132, 0.5)"
        );

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $proid        = $request['proid'];

        //OBTENER LAS FECHAS PARA EL EJE X
        if ($fecha_inicio &&  $fecha_final) {
            $fechas = dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                        ->where('proid', $proid)
                                        ->whereBetween('fec.fecfecha', [$fecha_inicio, $fecha_final])
                                        ->distinct('fec.fecid') 
                                        ->orderBy('fecfecha', 'ASC')
                                        ->get([
                                            'fec.fecid',
                                            'fecfecha'
                                        ]);
        }else{
            $fechas = dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                        ->where('proid', $proid)
                                        ->where('fec.fecfecha', '>=', Carbon::now()->subDays(30))
                                        ->distinct('fec.fecid') 
                                        ->orderBy('fecfecha', 'ASC')
                                        ->get([
                                            'fec.fecid',
                                            'fecfecha'
                                        ]);
        }

        foreach($fechas as $fecha){
            $labels_fechas[] = $fecha->fecfecha;
        }

        // BUCLE PARA RETORNAR LA DATA DEL PRODUCTO ORIGINAL 
        foreach ($fechas as $fecha) {
            
            $prp = prppreciosproductos::where('proid', $proid)
                                        ->where('fecid', $fecha->fecid)
                                        ->first([
                                            'prpprecio'
                                        ]);

            if($prp){
                $data_grafico[] = $prp->prpprecio;
            }else{
                $data_grafico[] = "0";
            }
        }

        $arr_data_grafico = array(
            "label" => "SOFTYS",
            "data"  => $data_grafico,
            "borderColor"     => "rgb(255, 99, 132)",
            "backgroundColor" => "rgba(255, 99, 132, 0.5)"
        );
        
        if ($arr_data_grafico) {
            $respuesta = true;
            $mensaje = 'Se obtuvo los datos del producto exitosamente';
        }else{
            $respuesta = false;
            $mensaje = 'Surgio un error al obtener la datos del producto';
        }
                        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'fechas'    => $labels_fechas,
            'datos'     => $arr_data_grafico
        ]);
    }

    public function MetDatosProductosCompetenciaGrafico(Request $request)
    {

        $respuesta = false;
        $mensaje = '';
        $labels_fechas = [];
        $data_grafico = [];
        $arr_data_grafico = array(
            "label"           => "",
            "data"            => [],
            "borderColor"     => "",
            "backgroundColor" => ""
        );

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $pagid        = $request['pagid'];
        $proid        = $request['proid'];

        if ($fecha_inicio &&  $fecha_final) {
            $fechas = dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                    ->where('proid', $proid)
                                    ->where('pagid', $pagid)
                                    ->whereBetween('fec.fecfecha', [$fecha_inicio, $fecha_final])
                                    ->distinct('fec.fecid') 
                                    ->orderBy('fecfecha', 'ASC')
                                    ->get([
                                        'fec.fecid',
                                        'fecfecha'
                                    ]);
        }else{
            $fechas = dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                    ->where('proid', $proid)
                                    ->where('pagid', $pagid)
                                    ->where('fec.fecfecha', '>=', Carbon::now()->subDays(30))
                                    ->distinct('fec.fecid') 
                                    ->orderBy('fecfecha', 'ASC')
                                    ->get([
                                        'fec.fecid',
                                        'fecfecha'
                                    ]);
        }

        foreach($fechas as $fecha){
            $labels_fechas[] = $fecha->fecfecha;
        }

        foreach ($fechas as $fecha) {
            
            $prp = dtpdatospaginas::where('proid', $proid)
                                    ->where('fecid', $fecha->fecid)
                                    ->where('pagid', $pagid)
                                    ->first([
                                        'dtpprecio'
                                    ]);

            if($prp){
                $data_grafico[] = $prp->dtpprecio;
            }else{
                $data_grafico[] = "0";
            }
        }

        $pag = pagpaginas::where('pagid', $pagid)
                            ->first([
                                'pagnombre',
                                'pagbordercolor',
                                'pagbackgroundcolor'
                            ]);
        $arr_data_grafico = array(
            "label" => $pag->pagnombre,
            "data"  => $data_grafico,
            "borderColor"     => $pag->pagbordercolor,
            "backgroundColor" => $pag->pagbackgroundcolor
        );
        
        if ($arr_data_grafico) {
            $respuesta = true;
            $mensaje = 'Se obtuvo los datos del homologados exitosamente';
        }else{
            $respuesta = false;
            $mensaje = 'Surgio un error al obtener la datos del homologado';
        }
                        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'fechas'    => $labels_fechas,
            'datos'     => $arr_data_grafico
        ]);
                                   
        
    }
}
