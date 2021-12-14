<?php

namespace App\Http\Controllers\Validaciones\RecuperarContrasenia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\RecuperarContrasenia\MetRecuperarContraseniaController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use Illuminate\Http\Request;

class RecuperarContraseniaController extends Controller
{
    public function ValEnviarCorreo(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'correo' => ['required', 'email']
        ];

        $this->validate($request, $rules, $customMessages);

        $enviarCorreo = new MetRecuperarContraseniaController;
        return $enviarCorreo->MetEnviarLinkResetEmail($request);
    }

    public function ValCambiarContrasenia(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'contrasenia' => ['required', 'min:4']
        ];

        $this->validate($request, $rules, $customMessages);

        $cambiar = new MetRecuperarContraseniaController;
        return $cambiar->MetFormularioResetearContrasenia($request);
    }
}
