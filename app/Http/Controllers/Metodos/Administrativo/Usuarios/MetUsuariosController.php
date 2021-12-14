<?php

namespace App\Http\Controllers\Metodos\Administrativo\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\perpersonas;
use App\Models\tputiposusuarios;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MetUsuariosController extends Controller
{
    public function MetCrearUsuario(Request $request)
    {
        $respuesta  = false;
        $mensaje    = '';

        $nombre        = $request['nombre'];
        $usuario       = $request['usuario'];
        $apell_paterno = $request['apell_paterno'];
        $apell_materno = $request['apell_materno'];
        $tpuid         = $request['tpuid'];
        $correo        = $request['correo'];
        $contrasenia   = $request['contrasenia'];
        $token_adm     = $request->header('token');

        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first(['tpuid']);
        $per = perpersonas::where('pernombre',$nombre)
                            ->where('perapellpaterno', $apell_paterno)
                            ->where('perapellmaterno', $apell_materno)
                            ->first(['perid']);
        $usu_empid = usuusuarios::where('usutoken', $token_adm)->first(['empid']);

        if ($per) {
            $persona_id = strval($per->perid);
        }else{
            $persona = new perpersonas();
            $persona->pernombrecompleto = $nombre." ".$apell_paterno." ".$apell_materno;
            $persona->pernombre         = $nombre;
            $persona->perapellpaterno   = $apell_paterno;
            $persona->perapellmaterno   = $apell_materno;
            if($persona->save()){
                $persona_id = $persona->perid;
            }else{
                $persona_id = null;
            }
        }
        if (!$tpu) {
            $respuesta = false;
            $mensaje = 'No existe el ID del tipo de usuario ingresado';
        }
        if (!$token_adm) {
            $respuesta = false;
            $mensaje = 'Ingrese un token válido';
        }
        if ($tpu && $per && $usu_empid) {
            $usutoken = Str::random(60);
            $usuc = new usuusuarios();
            $usuc->usuusuario     = $usuario;
            $usuc->usucontrasenia = Hash::make($contrasenia);
            $usuc->tpuid          = $tpuid;
            $usuc->perid          = $persona_id;
            $usuc->empid          = $usu_empid->empid;
            $usuc->usutoken       = $usutoken;
            $usuc->usucorreo      = $correo;
            if($usuc->save()){
                $respuesta = true;
                $mensaje = 'Usuario registrado correctamente';
            }
        }
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }
}
