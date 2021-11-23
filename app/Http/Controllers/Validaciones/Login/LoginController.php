<?php

namespace App\Http\Controllers\Validaciones\Login;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Login\MetLoginController;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function ValLogin(Request $request)
    {
        $rules = [
            'usuario' => ['required'],
            'contrasenia' => ['required']
        ];

        $this->validate($request, $rules);

        $login = new MetLoginController;
        return $login->MetLogin($request);
    }
}
