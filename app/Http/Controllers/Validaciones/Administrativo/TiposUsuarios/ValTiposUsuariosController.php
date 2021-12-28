<?php

namespace App\Http\Controllers\Validaciones\Administrativo\TiposUsuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Administrativo\TiposUsuarios\MetTiposUsuariosController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use App\Models\empempresas;
use App\Models\tputiposusuarios;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValTiposUsuariosController extends Controller
{
    public function ValCrearTipoUsuario(Request $request)
    {
        $respuesta = false;
        $mensaje = '';

        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'     => ['required','string'],
            'privilegio' => ['required','string'],
        ];

        $this->validate($request, $rules, $customMessages);

        $token = $request->header('token');

        $usu = usuusuarios::where('usutoken', $token)->first('usuid');

        if ($usu) {
            $tpuc = new MetTiposUsuariosController;
            return $tpuc->MetCrearTipoUsuario($request);
        }else{
            $respuesta = false;
            $mensaje = 'Ingrese un token valido';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function ValEditarTipoUsuario(Request $request, $tpuid)
    {
        $respuesta = false;
        $mensaje = '';

        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre' => ['required', 'string']
        ];
        
        $this->validate($request, $rules, $customMessages);

        $token = $request->header('token');

        $usu = usuusuarios::where('usutoken', $token)->first('usuid');
        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');

        if ($usu) {
            if ($tpu) {
                $tpuu = new MetTiposUsuariosController;
                return $tpuu->MetEditarTipoUsuario($request, $tpuid);
            }else{
                $respuesta = false;
                $mensaje = 'Ingrese un ID tipo usuario valido';
            }
        }else{
            $respuesta = false;
            $mensaje = 'Ingrese un token valido';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function ValEliminarTipoUsuario(Request $request, $tpuid)
    {
        $respuesta = false;
        $mensaje = '';

        $token = $request->header('token');

        $usu = usuusuarios::where('usutoken', $token)->first('usuid');
        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');

        if ($usu) {
            if ($tpu) {
                $tpud = new MetTiposUsuariosController;
                return $tpud->MetEliminarTipoUsuario($request, $tpuid);
            }else{
                $respuesta = false;
                $mensaje = 'Ingrese un ID tipo de usuario valido';
            }
        }else{
            $respuesta = false;
            $mensaje = 'Ingrese un token valido';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function ValListarTiposUsuarios($empid)
    {
        $emp = empempresas::where('empid', $empid)->first('empid');

        if ($emp) {
            $tpu = new MetTiposUsuariosController;
            return $tpu->MetObtenerListaTiposUsuarios($empid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válido'
            ]);
        }
    }
}
