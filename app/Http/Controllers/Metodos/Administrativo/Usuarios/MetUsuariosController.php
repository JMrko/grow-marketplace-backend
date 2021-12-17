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

        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');
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

    public function MetEliminarUsuario($usuid)
    {
        $respuesta  = false;
        $mensaje    = '';

        $usud = usuusuarios::where('usuid', $usuid)
                                    ->delete();
            
        if ($usud == 1) {
            $respuesta = true;
            $mensaje   = 'Usuario eliminado exitosamente';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function MetEditarUsuario(Request $request, $usuid)
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

        $perid = usuusuarios::where('usuid',$usuid)->first(['perid']);
        
        if ($perid) {
            $peru = perpersonas::where('perid',$perid->perid)
                                ->update([
                                    'pernombrecompleto' => $nombre." ".$apell_paterno." ".$apell_materno,
                                    'pernombre'         => $nombre,
                                    'perapellpaterno'   => $apell_paterno,
                                    'perapellmaterno'   => $apell_materno
                                ]);
            if ($peru == 0) {
                $respuesta = false;
                $mensaje   = 'No se pudo actualizar los datos personales del usuario';
            }
        }

        $usuu = usuusuarios::where('usuid', $usuid)
                                    ->update([
                                        'usuusuario'     => $usuario,
                                        'usucontrasenia' => Hash::make($contrasenia),
                                        'usucorreo'      => $correo,
                                        'tpuid'          => $tpuid
                                    ]);
        
        if ($usuu == 1) {
            $respuesta = true;
            $mensaje   = 'Se actualizo los datos ingresados del usuario';
        }else {
            $respuesta = false;
            $mensaje   = 'No se pudo actualizar el usuario';
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }

    public function MetObtenerListaUsuarios($empid)
    {
        $respuesta = false;
        $mensaje   =  '';

        $usu = usuusuarios::join('tputiposusuarios as tpu', 'tpu.tpuid', 'usuusuarios.tpuid')
                            ->join('perpersonas as per', 'per.perid', 'usuusuarios.perid')
                            ->where('usuusuarios.empid', $empid)                                
                            ->get([
                                'usuid',
                                'tpunombre',
                                'pernombrecompleto',
                                'usuusuario',
                                'usucorreo',
                                'usucontrasenia',
                                'usuusuarios.created_at'
                            ]);
        $respuesta = true;
        $mensaje   = 'Se obtuvo la lista de usuarios satisfactoriamente';

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $usu
        ]);
    }

}
