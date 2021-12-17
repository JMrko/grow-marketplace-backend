<?php

namespace App\Http\Controllers\Metodos\Upload;

use App\Http\Controllers\Controller;
use App\Models\carcargasarchivos;
use Illuminate\Http\Request;

class MetArchivosController extends Controller
{
    public function MetObtenerListaArchivosCargados($empid)
    {
        $respuesta = false;
        $mensaje   =  '';

        $car = carcargasarchivos::join('tcatiposcargasarchivos as tca', 'tca.tcaid', 'carcargasarchivos.tcaid')
                            ->join('usuusuarios as usu', 'usu.usuid', 'carcargasarchivos.usuid')
                            ->join('perpersonas as per', 'per.perid', 'usu.perid')
                            ->where('carcargasarchivos.empid',$empid)
                            ->get([
                                'carid',
                                'carnombre',
                                'tcanombre',
                                'pernombrecompleto',
                                'carcargasarchivos.created_at'
                            ]);
        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de archivos cargados satisfactoriamente';

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $car
        ]);
    }
}
