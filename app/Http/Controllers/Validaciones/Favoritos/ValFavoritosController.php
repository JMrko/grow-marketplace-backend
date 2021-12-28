<?php

namespace App\Http\Controllers\Validaciones\Favoritos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Favoritos\MetFavoritosController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use App\Models\favfavoritos;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValFavoritosController extends Controller
{
    public function ValCrearFavoritos(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre' => ['required','string'],
            'url'    => ['required','string'],
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $token = $request->header('token');
        $usu = usuusuarios::where('usutoken', $token)->first('usutoken');

        if ($usu) {
            $usuc = new MetFavoritosController;
            return $usuc->MetCrearFavoritos($request);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un token de usuario válido'
            ]);
        }
    }

    public function ValEliminarFavoritos(Request $request, $favid)
    {
        $fav = favfavoritos::where('favid', $favid)->first('favid');

        $token = $request->header('token');
        $usu = usuusuarios::where('usutoken', $token)->first('usutoken');

        if ($fav) {
            if ($usu) {
                $favd = new MetFavoritosController;
                return $favd->MetEliminarFavoritos($request, $favid);
            }else{
                 $respuesta = false;
                 $mensaje = 'Ingrese un token valido';
            }
        }else{
            $respuesta = false;
            $mensaje = 'Ingrese un ID de favorito valido';
        }
        return response()->json([
            'respuesta' => $respuesta,
            'mensaje'   => $mensaje
        ]);
    }
}
