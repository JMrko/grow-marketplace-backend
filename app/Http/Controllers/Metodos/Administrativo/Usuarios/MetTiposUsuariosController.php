<?php

namespace App\Http\Controllers\Metodos\Administrativo\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetTiposUsuariosController extends Controller
{
    public function MetCrearTipoUsuario(Request $request)
    {
        $respuesta  = false;
        $mensaje    = '';

        $nombre     = $request['privilegio'];
        $privilegio = $request['privilegio'];
        $token_adm     = $request->header('token');

    }
}
