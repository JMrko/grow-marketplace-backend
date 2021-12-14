<?php

namespace App\Http\Controllers\Validaciones\Administrativo\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Administrativo\Usuarios\MetUsuariosController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use Illuminate\Http\Request;

class ValUsuariosController extends Controller
{
    public function ValCrearUsuario(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'        => ['required'],
            'usuario'       => ['required'],
            'apell_paterno' => ['required'],
            'apell_materno' => ['required'],
            'tpuid'         => ['required'],
            'correo'        => ['required'],
            'contrasenia'   => ['required'],
        ];

        $this->validate($request, $rules, $customMessages);

        $nuevo_usuario = new MetUsuariosController;
        return $nuevo_usuario->MetCrearUsuario($request);
    }
}
