<?php

namespace App\Http\Controllers\Metodos\Favoritos;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Models\favfavoritos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class MetFavoritosController extends Controller
{
    public function MetCrearFavoritos(Request $request)
    {
        $respuesta = false;
        $mensaje = '';
        $tpaid = 1;
        $audlog = '';
        $audtabla = 'favfavoritos';
        $audpk = '';

        $token      = $request->header('token');
        $nombre_fav = $request['nombre'];
        $url_fav    = $request['url'];
        
        $usu = usuusuarios::where('usutoken', $token)
                            ->first('usuid');

        $orden = favfavoritos::where('usuid', $usu->usuid)
                                ->orderBy('favorden', 'desc')
                                ->first('favorden');
        if ($orden) {
            $orden = $orden->favorden + 1;
        }else{
            $orden = 1;
        }

        $favorito = new favfavoritos();
        $favorito->usuid     = $usu->usuid;
        $favorito->favnombre = $nombre_fav;
        $favorito->favurl    = $url_fav;
        $favorito->favorden  = $orden;

        if ($favorito->save()) {
            $respuesta = true;
            $mensaje = 'Se agrego a favoritos exitosamente';
        }else{
            $respuesta = false;
            $mensaje = 'Surgio un error al momento de guardar en favoritos';
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
                'Crear favoritos',
                'CREAR',
                '/crear-favorito', 
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Se agrego a favoritos y registro de auditoria exitoso';
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

    public function MetEliminarFavoritos(Request $request, $favid)
    {
        $respuesta = false;
        $mensaje = '';
        $tpaid = 3;
        $audlog = '';
        $audtabla = 'favfavoritos';
        $audpk = '';

        $token      = $request->header('token');

        $usu = usuusuarios::where('usutoken', $token)
                            ->first('usuid');
        $favd = favfavoritos::where('favid', $favid)
                                ->delete();

        if ($favd == 1) {
            $respuesta = true;
            $mensaje   = 'Favorito eliminado exitosamente';
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
                'Eliminar favoritos',
                'ELIMINAR',
                '/eliminar-favorito/{favid}', 
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Se elimino un registro de favoritos y registro de auditoria exitoso';
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
