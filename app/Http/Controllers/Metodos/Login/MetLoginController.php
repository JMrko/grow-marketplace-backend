<?php

namespace App\Http\Controllers\Metodos\Login;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Models\empempresas;
use App\Models\perpersonas;
use App\Models\tputiposusuarios;
use App\Models\tuptiposusuariospermisos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MetLoginController extends Controller
{
    public function MetCrearUsuario(Request $request)
    {
        $usutoken = "";
        $persona_id = "";
        $tpaid = 1;
        $audtabla= "usuusuarios";
        $audlog = "";

        $usuario       = $request['usuario'];
        $contrasenia   = $request['contrasenia'];
        $tp_usuario    = $request['tipo_usuario_id'];
        $nombre        = $request['nombre'];
        $apell_paterno = $request['apell_paterno'];
        $apell_materno = $request['apell_materno'];
        $empresa_id    = $request['empresa_id'];
        $correo        = $request['correo'];

        // Se va a consultar en la bd si existe algun registro con esos ID
        $tpu = tputiposusuarios::where('tpuid',$tp_usuario)->first(['tpuid']);
        $per = perpersonas::where('pernombre',$nombre)
                            ->where('perapellpaterno', $apell_paterno)
                            ->where('perapellmaterno', $apell_materno)
                            ->first(['perid']);
        $emp = empempresas::where('empid',$empresa_id)->first(['empid']);

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
        if(!$tpu){
            $respuesta = false;
            $mensaje = 'No existe el ID del tipo de usuario ingresado';
        }
        if (!$emp) {
            $respuesta = false;
            $mensaje = 'No existe el ID de la empresa ingresada';
        }
        if ($tpu && $emp && $persona_id) {
            $usutoken = Str::random(60);
            $usuc = new usuusuarios();
            $usuc->usuusuario     = $usuario;
            $usuc->usucontrasenia = Hash::make($contrasenia);
            $usuc->tpuid          = $tp_usuario;
            $usuc->perid          = $persona_id;
            $usuc->empid          = $empresa_id;
            $usuc->usutoken       = $usutoken;
            $usuc->usucorreo      = $correo;
            if($usuc->save()){
                $audpk = $usuc->usuid;
                $respuesta = true;
                $mensaje = 'Usuario registrado correctamente';
            }
           
        }
        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);

        if ($respuesta == true || $respuesta == false) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $usutoken,
                null,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Crear nuevo usuario',
                'CREAR',
                '/configuracion/usuarios/crear/usuario', //ruta
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Usuario y registro de auditoria registrado correctamente';
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

    public function MetLogin(Request $request)
    {
        $respuesta = false;
        $mensaje   = '';
        $datos     = [];
        $usutoken  = '';
        $tpaid     = 4;
        $audlog    = "";
        $audpk     = "";
        $audtabla  = "usuusuarios";

        $usuario = $request['usuario'];
        $contrasenia = $request['contrasenia'];

        $usu = usuusuarios::join('perpersonas as per', 'per.perid', 'usuusuarios.perid')
                                    ->join('tputiposusuarios as tpu', 'tpu.tpuid', 'usuusuarios.tpuid')
                                    ->where('usuusuario', $usuario)
                                    ->first([
                                        'usuid',
                                        'per.perid',
                                        'pernombrecompleto',
                                        'pernombre',
                                        'perapellpaterno',
                                        'perapellmaterno',
                                        'tpu.tpuid',
                                        'tpunombre',
                                        'tpuprivilegio',
                                        'usuusuario',
                                        'usucontrasenia',
                                        'usucorreo',
                                        'usuimagen'
                                    ]);
        
        if ($usu) {
            if (Hash::check($contrasenia, $usu->usucontrasenia)) {
                
                $tuptiposusuariospermisos = tuptiposusuariospermisos::join('pempermisos as pem', 'pem.pemid', 'tuptiposusuariospermisos.pemid')
                                                                    ->where('tuptiposusuariospermisos.tpuid', $usu->tpuid )
                                                                    ->get([
                                                                        'tuptiposusuariospermisos.tupid',
                                                                        'pem.pemnombre',
                                                                        'pem.pemslug'
                                                                    ]);

                if(sizeof($tuptiposusuariospermisos) > 0){
                    $usu->permisos = $tuptiposusuariospermisos;
                }else{
                    $usu->permisos = [];
                }

                $token = usuusuarios::where('usuusuario',$usuario)->first(['usutoken']);
                $usutoken = $token->usutoken;
                $datos = $usu;
                $mensaje = "Bienvenido, ".$usuario." es un gusto volver a verte por aquí";
                $respuesta = true;

            }else{
                $respuesta = false;
                $mensaje = "Lo sentimos, el usuario o contraseña es incorrecta";
            }
        }else{
            $respuesta = false;
            $mensaje = "Lo sentimos, el usuario o contraseña es incorrecta";
        }
        
        $requestSalida = response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $datos,
            'token'     => $usutoken
        ]);

        if ($respuesta == true || $respuesta == false) {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $usutoken,
                null,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Login usuario',
                'LOGIN',
                '/login', //ruta
                $audlog,
                $audpk,
                $audtabla
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Registro de auditoria registrado correctamente';
            }else{
                $respuesta = false;
                $mensaje = 'Error al registrar auditoria';
            }
        }

        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => $datos,
            'token'     => $usutoken
        ]);

    }
}
