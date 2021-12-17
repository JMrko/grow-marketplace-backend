<?php

namespace App\Http\Controllers\Metodos\Administrativo\Permisos;

use App\Http\Controllers\Controller;
use App\Models\tputiposusuarios;
use Illuminate\Http\Request;

class MetPermisosController extends Controller
{
    public function MetObtenerListaPermisos($tpuid)
    {
        $respuesta = false;
        $mensaje   =  '';

        $pem = tputiposusuarios::join('tuptiposusuariospermisos as tup', 'tup.tpuid', 'tputiposusuarios.tpuid')
                                ->join('pempermisos as pem', 'pem.pemid', 'tup.pemid')
                                ->where('tputiposusuarios.tpuid', $tpuid)
                                ->get([
                                    'pemnombre',
                                    'pemslug',
                                    'pemruta',
                                    'pem.created_at'
                                ]);
        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de permisos satisfactoriamente';

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $pem
        ]);
    }
}
