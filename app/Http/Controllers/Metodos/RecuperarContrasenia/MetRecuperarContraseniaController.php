<?php

namespace App\Http\Controllers\Metodos\RecuperarContrasenia;

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\Controller;
use App\Mail\CorreoResetContrasenia;
use App\Models\usuusuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MetRecuperarContraseniaController extends Controller
{
    public function MetEnviarLinkResetEmail(Request $request){

        $respuesta = false;
        $mensaje   =  '';
        $correo    = $request['correo'];
        $usu       = usuusuarios::where('usucorreo',$correo)->first(['usuusuario']); 

        if ($usu) {
            $data = ['correo'=> $correo, 'usuario' => $usu->usuusuario];
            Mail::to($correo)->send(new CorreoResetContrasenia($data));
            $respuesta = true;
            $mensaje = "El correo de recuperación fue enviado correctamente";
        }else{
            $mensaje = 'Lo sentimos ese usuario no esta registrado';
            $respuesta = false;
        }
            
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje,
            'datos'     => []
        ]);
    }

    public function MetFormularioResetearContrasenia(Request $request){

        $respuesta = false;
        $mensaje = '';
        $tpaid = 5;
        $audlog    = "";
        $audpk     = "";
        $audtabla  = "";

        $contraseniaNueva = $request['contrasenia'];
        $token            = $request->header('token');

        $usu = usuusuarios::where('usutoken',$token)->first(['usuusuario', 'usucontrasenia']);
        
        if ($usu) {
            usuusuarios::where('usuusuario', $usu->usuusuario)
                        ->where('usucontrasenia', $usu->usucontrasenia)
                        ->update(['usucontrasenia' => Hash::make($contraseniaNueva)]);
            $respuesta = true;
            $mensaje = 'Su contraseña fue actualizada correctamente';
        }else{
            $respuesta = false;
            $mensaje = 'No existe usuario con dicho token';
        }                                 

        $requestSalida =  response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);

        if ($respuesta == true && $mensaje == "Su contraseña fue actualizada correctamente") {
            $AuditoriaController = new AuditoriaController;
            $registrarAuditoria  = $AuditoriaController->registrarAuditoria(
                $token,
                null,
                $tpaid,
                null,
                $request,
                $requestSalida,
                'Envio de Formulario de recuperar contraseña',
                'RECUPERAR CONTRASEÑA',
                '/cambiar-contrasenia', //ruta
                $audlog,
                $audpk,
                $audtabla   
            );
            if ($registrarAuditoria == true) {
                $respuesta = true;
                $mensaje = 'Cambio de contraseña y registro de auditoria registrado correctamente';
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
