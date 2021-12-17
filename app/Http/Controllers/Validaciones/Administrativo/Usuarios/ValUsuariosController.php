<?php

namespace App\Http\Controllers\Validaciones\Administrativo\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Administrativo\Usuarios\MetUsuariosController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use App\Models\empempresas;
use App\Models\usuusuarios;
use Illuminate\Http\Request;

class ValUsuariosController extends Controller
{
    public function ValCrearUsuario(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'        => ['required','string'],
            'usuario'       => ['required','string','unique'],
            'apell_paterno' => ['required','string'],
            'apell_materno' => ['required','string'],
            'tpuid'         => ['required'],
            'correo'        => ['required','email'],
            'contrasenia'   => ['required','min:4'],
        ];

        $this->validate($request, $rules, $customMessages);

        $usuc = new MetUsuariosController;
        return $usuc->MetCrearUsuario($request);
    }

    public function ValEditarUsuario(Request $request, $usuid)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'        => ['required','string'],
            'usuario'       => ['required','string'],
            'apell_paterno' => ['required','string'],
            'apell_materno' => ['required','string'],
            'tpuid'         => ['required'],
            'correo'        => ['required','email'],
            'contrasenia'   => ['required','min:4'],
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $usu = usuusuarios::where('usuid', $usuid)->first('usuid');

        if ($usu) {
            $usuu = new MetUsuariosController;
            return $usuu->MetEditarUsuario($request, $usuid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de usuario válido'
            ]);
        }
    }

    public function ValEliminarUsuario($usuid)
    {
        $usu = usuusuarios::where('usuid', $usuid)->first('usuid');

        if ($usu) {
            $usud = new MetUsuariosController;
            return $usud->MetEliminarUsuario($usuid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de usuario válido'
            ]);
        }
    }

    public function ValListarUsuarios($empid)
    {
        $emp = empempresas::where('empid', $empid)->first('empid');

        if ($emp) {
            $usu = new MetUsuariosController;
            return $usu->MetObtenerListaUsuarios($empid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válido'
            ]);
        }
    }
}
