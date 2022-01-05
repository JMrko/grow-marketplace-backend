<?php

namespace App\Http\Controllers\Metodos\Administrativo\TiposUsuarios;

use App\Http\Controllers\AuditoriaController;
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
        $tpaid      = 1;
        $audlog     = '';
        $audtabla   = 'tputiposusuarios';
        
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
                $audpk = $tipo->tpuid;
                $respuesta = true;
                $mensaje   = 'Tipo de usuario registrado exitosamente';
            }
        }else{
            $respuesta = false;
            $mensaje   = 'Ingrese un token de Administrador válido';
        }
        
        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);

        if ($respuesta == true || $respuesta == false) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token_adm,
                null,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Crear Tipo Usuario',
                'CREAR',
                '/crear-tipo-usuario', 
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Crear tipo usuario y registro de auditoria exitoso';
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

    public function MetEliminarTipoUsuario(Request $request, $tpuid)
    {
        $respuesta  = false;
        $mensaje    = '';
        $tpaid      = 3;
        $audlog     = '';
        $audtabla   = 'tputiposusuarios';
        $audpk      = '';

        $token = $request->header('token');
        $usu = usuusuarios::where('tpuid', $tpuid)
                            ->update(['tpuid' => '1']);
                            
        if ($usu == 1 || $usu == 0) {
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

        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);

        if ($respuesta == true || $respuesta == false) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token,
                null,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Eliminar Tipo de Usuario',
                'ELIMINAR',
                '/eliminar-tipo-usuario/{tpuid}', 
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Eliminar tipo de usuario y registro de auditoria exitoso';
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

    public function MetEditarTipoUsuario(Request $request, $tpuid)
    {
        $respuesta  = false;
        $mensaje    = '';
        $tpaid      = 2;
        $audlog     = '';
        $audtabla   = 'tputiposusuarios';

        $nombre     = $request['nombre'];
        $token      = $request->header('token');

        $tpuu = tputiposusuarios::where('tpuid', $tpuid)
                                    ->update(['tpunombre' => $nombre]);
        
        if ($tpuu == 1) {
            $respuesta = true;
            $mensaje   = 'Se actualizo los datos ingresados del tipo de usuario';
        }else {
            $respuesta = false;
            $mensaje   = 'No se pudo actualizar el tipo de usuario';
        }

        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);

        if ($respuesta == true || $respuesta == false) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token,
                null,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Editar Tipo de Usuario',
                'EDITAR',
                '/editar-tipo-usuario/{tpuid}', 
                $audlog,
                $tpuid,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Editar tipo usuario y registro de auditoria exitoso';
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
