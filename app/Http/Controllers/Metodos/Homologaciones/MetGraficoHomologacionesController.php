<?php

namespace App\Http\Controllers\Metodos\Homologaciones;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\pagpaginas;
use Illuminate\Http\Request;

class MetGraficoHomologacionesController extends Controller
{
    public function MetGrafico($proid)
    {
        $respuesta = false;
        $mensaje = '';
        $paginas = [];
        $fechas_pagina = [];
        //OBTENER LAS FECHAS PARA EL EJE X
        $fechas = dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                    ->where('proid', $proid)
                                    ->distinct()
                                    ->get([
                                        'fecfecha'
                                    ]);//orderby de fecfechas
                                   
        //OBTENER LOS ID PAGINAS DE LAS FECHAS OBTENIDAS
        foreach ($fechas as $fecha) {
           $datos_pagina =  dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid') 
                                // ->join('pagpaginas as pag', 'pag.pagid', 'dtpdatospaginas.pagid')
                                ->where('fecfecha', $fecha->fecfecha)
                                ->where('proid', $proid)
                                ->get([
                                    'pagid'
                                ]);

            for ($i=0; $i < sizeof($datos_pagina); $i++) { 
                $paginas[]= $datos_pagina[$i]->pagid;
            }
        }

        $paginas_unicas = array_unique($paginas);
 
        //ALMACENAR EN UN ARRAY EL IDPAG CON LAS FECHAS DE CADA PAGINA
        for ($i=0; $i < sizeof($paginas_unicas) ; $i++) { 
            $pag_fechas = dtpdatospaginas::join('fecfechas as fec', 'fec.fecid', 'dtpdatospaginas.fecid')
                                            ->where('proid', $proid)
                                            ->where('dtpdatospaginas.pagid', $paginas_unicas[$i])
                                            ->get([
                                                'fecfecha'
                                            ]);

            $nombre = pagpaginas::where('pagid', $paginas_unicas[$i])
                                    ->first('pagnombre');

           $fechas_pagina[$i]['label'] = $nombre->pagnombre; 
           $fechas_pagina[$i]['data'] = $pag_fechas;
        }
        

        if ($fechas && $fechas_pagina) {
            $respuesta = true;
            $mensaje = 'Se obtuvo los datos del producto exitosamente';
        }else{
            $respuesta = false;
            $mensaje = 'Surgio un error al obtener la datos del producto';
        }
                        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'fechas'    => $fechas,
            'datos'     => $fechas_pagina
        ]);
    }
}
