<?php

namespace App\Http\Controllers\Validaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomMessagesController extends Controller
{
    public function CustomMensajes()
    {
        return [
            'required'     => 'El campo :attribute es requerido',   
            'correo.email' => 'El campo correo requiere un correo válido',
            'min'          => 'El campo :attribute debe contener al menos 4 carácteres',
            'string'       => 'El campo debe ser una cadena de carácteres',
            'unique'       => 'El campo debe ser unico, ingrese otro valor'
        ];
    }
}
