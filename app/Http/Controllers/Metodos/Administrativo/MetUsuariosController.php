<?php

namespace App\Http\Controllers\Metodos\Administrativo;

use App\Http\Controllers\Controller;
use App\Models\tputiposusuarios;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class MetUsuariosController extends Controller
{
    public function MetObtenerListaTiposUsuarios($empid)
    {
        $respuesta = false;
        $mensaje   =  '';

        if ($empid) {
            $tpu = tputiposusuarios::where('empid',$empid)
                            ->get([
                                'tpuid',
                                'tpunombre',
                                'created_at'
                            ]);
            $respuesta = true;
            $mensaje   = 'Se obtuvo la lista de tipos de usuarios satisfactoriamente';
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un ID de empresa válido';
        }
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $tpu
        ]);
    }

    public function MetObtenerListaUsuarios($empid)
    {
        $respuesta = false;
        $mensaje   =  '';

        if ($empid) {
           $usu = usuusuarios::join('tputiposusuarios as tpu', 'tpu.tpuid', 'usuusuarios.tpuid')
                                ->join('perpersonas as per', 'per.perid', 'usuusuarios.perid')
                                ->where('usuusuarios.empid', $empid)                                
                                ->get([
                                    'usuid',
                                    'tpunombre',
                                    'pernombrecompleto',
                                    'usuusuario',
                                    'usucorreo',
                                    'usucontrasenia'
                                ]);
            $respuesta = true;
            $mensaje   = 'Se obtuvo la lista de usuarios satisfactoriamente';
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un ID de empresa válido';
        }
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $usu
        ]);
    }

    public function MetObtenerListaPermisos($tpuid)
    {
        $respuesta = false;
        $mensaje   =  '';
        
        if ($tpuid) {

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
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un ID de tipo de usuario válido';
        }
        

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $pem
        ]);
    }
}
