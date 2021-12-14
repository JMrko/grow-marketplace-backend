<?php

namespace App\Http\Controllers\Validaciones\Login;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Login\MetLoginController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function ValLogin(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'usuario'         => ['required'],
            'contrasenia'     => ['required', 'min:4'],
        ];

        $this->validate($request, $rules, $customMessages);

        $login = new MetLoginController;
        return $login->MetLogin($request);
    }

    public function ValRegistrarUsuario(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'usuario'          => ['required'],
            'contrasenia'      => ['required','min:4'],
            'tipo_usuario_id'  => ['required'],
            'nombre'           => ['required', 'string'],
            'apell_paterno'    => ['required', 'string'],
            'apell_materno'    => ['required', 'string'],
            'empresa_id'       => ['required'],
            'correo'           => ['required','email']
        ];

        $this->validate($request, $rules, $customMessages);

        $crear = new MetLoginController;
        return $crear->MetCrearUsuario($request);
    }
}
