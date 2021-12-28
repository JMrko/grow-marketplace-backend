<?php

namespace App\Http\Controllers\Validaciones\Administrativo\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Administrativo\Usuarios\MetUsuariosController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use App\Models\empempresas;
use App\Models\tputiposusuarios;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValUsuariosController extends Controller
{
    public function ValCrearUsuario(Request $request)
    {
        $respuesta = false;
        $mensaje = '';

        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'        => ['required','string'],
            'usuario'       => ['required','string'],
            'apell_paterno' => ['required','string'],
            'apell_materno' => ['required','string'],
            'tpuid'         => ['required'],
            'correo'        => ['required','email'],
            'contrasenia'   => ['required','min:4'],
        ];

        $this->validate($request, $rules, $customMessages);

        $tpuid = $request['tpuid'];
        $token = $request->header('token');

        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');
        $usu = usuusuarios::where('usutoken', $token)->first('usuid');

        if ($usu) {
            if ($tpu) {
                $usuc = new MetUsuariosController;
                return $usuc->MetCrearUsuario($request);
            }else{
                $respuesta = false;
                $mensaje = 'Ingrese un ID de tipo de usuario valido';
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

    public function ValEditarUsuario(Request $request, $usuid)
    {
        $respuesta = false;
        $mensaje = '';

        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'        => ['required','string'],
            'usuario'       => ['required','string'],
            'apell_paterno' => ['required','string'],
            'apell_materno' => ['required','string'],
            'tpuid'         => ['required'],
            'correo'        => ['required','email'],
            'contrasenia'   => ['required','min:4'],
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $token = $request->header('token');

        $usu_token = usuusuarios::where('usutoken', $token)->first('usuid');
        $usu = usuusuarios::where('usuid', $usuid)->first('usuid');

        if ($usu_token) {
            if ($usu) {
                $usuu = new MetUsuariosController;
                return $usuu->MetEditarUsuario($request, $usuid);
            }else{
                $respuesta = false;
                $mensaje = 'Ingrese un ID de usuario valido';
            }
        }else{
            $respuesta = false;
            $mensaje = 'Ingrese un token de usuario valido';
        }
        
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function ValEliminarUsuario(Request $request, $usuid)
    {
        $respuesta = false;
        $mensaje = '';

        $token = $request->header('token');

        $usu_token = usuusuarios::where('usutoken', $token)->first('usutoken');
        $usu = usuusuarios::where('usuid', $usuid)->first('usuid');

        if ($usu_token) {
            if ($usu) {
                $usud = new MetUsuariosController;
                return $usud->MetEliminarUsuario($request, $usuid);
            }else{
               $respuesta = false;
               $mensaje = 'Ingrese un ID de usuario valido';
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

    public function ValListarUsuarios($empid)
    {
        $emp = empempresas::where('empid', $empid)->first('empid');

        if ($emp) {
            $usu = new MetUsuariosController;
            return $usu->MetObtenerListaUsuarios($empid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válido'
            ]);
        }
    }
}
