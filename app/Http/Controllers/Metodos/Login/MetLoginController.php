<?php

namespace App\Http\Controllers\Metodos\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetLoginController extends Controller
{
    public function MetLogin(Request $request)
    {
        $usuario = $request['usuario'];
        $contrasenia = $request['contrasenia'];
    }
}
