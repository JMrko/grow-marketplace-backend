<?php

namespace App\Http\Controllers\Metodos\Administrativo\TiposUsuarios;

use App\Http\Controllers\Controller;
use App\Models\tputiposusuarios;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class MetTiposUsuariosController extends Controller
{
    public function MetCrearTipoUsuario(Request $request)
    {
        $respuesta  = false;
        $mensaje    = '';

        $nombre     = $request['nombre'];
        $privilegio = $request['privilegio'];
        $token_adm  = $request->header('token');

        $usu = usuusuarios::where('usutoken', $token_adm)->first('empid');

        if ($usu) {
            $tipo = new tputiposusuarios();
            $tipo->empid =  $usu->empid;
            $tipo->tpunombre = $nombre;
            $tipo->tpuprivilegio = $privilegio;
            if ($tipo->save()) {
                $respuesta = true;
                $mensaje   = 'Tipo de usuario registrado exitosamente';
            }
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un token de Administrador válido';
        }
        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function MetEliminarTipoUsuario($tpuid)
    {
        $respuesta  = false;
        $mensaje    = '';

        $usu = usuusuarios::where('tpuid', $tpuid)
                            ->update(['tpuid' => '1']);
        
        if ($usu == 1) {
            $tpud = tputiposusuarios::where('tpuid', $tpuid)
                                        ->delete();

            if ($tpud == 1) {
                $respuesta = true;
                $mensaje   = 'Tipo de usuario eliminado exitosamente';
            }
        }else{
            $respuesta = false;
            $mensaje   = 'No se pudo el tipo de usuario';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function MetEditarTipoUsuario(Request $request, $tpuid)
    {
        $respuesta  = false;
        $mensaje    = '';

        $nombre     = $request['nombre'];

        $tpuu = tputiposusuarios::where('tpuid', $tpuid)
                                    ->update(['tpunombre' => $nombre]);
        
        if ($tpuu == 1) {
            $respuesta = true;
            $mensaje   = 'Se actualizo los datos ingresados del tipo de usuario';
        }else {
            $respuesta = false;
            $mensaje   = 'No se pudo actualizar el tipo de usuario';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function MetObtenerListaTiposUsuarios($empid)
    {
        $respuesta = false;
        $mensaje   =  '';

        $tpu = tputiposusuarios::where('empid',$empid)
                        ->get([
                            'tpuid',
                            'tpunombre',
                            'created_at'
                        ]);
        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de tipos de usuarios satisfactoriamente';

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $tpu
        ]);
    }
}
