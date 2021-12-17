<?php

namespace App\Http\Controllers\Validaciones\Administrativo\TiposUsuarios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Metodos\Administrativo\TiposUsuarios\MetTiposUsuariosController;
use App\Http\Controllers\Validaciones\CustomMessagesController;
use App\Models\empempresas;
use App\Models\tputiposusuarios;
use Illuminate\Http\Request;

class ValTiposUsuariosController extends Controller
{
    public function ValCrearTipoUsuario(Request $request)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre'     => ['required','string'],
            'privilegio' => ['required','string'],
        ];

        $this->validate($request, $rules, $customMessages);

        $tpuc = new MetTiposUsuariosController;
        return $tpuc->MetCrearTipoUsuario($request);
    }

    public function ValEditarTipoUsuario(Request $request, $tpuid)
    {
        $mensajes = new CustomMessagesController;
        $customMessages = $mensajes->CustomMensajes();

        $rules = [
            'nombre' => ['required', 'string']
        ];
        
        $this->validate($request, $rules, $customMessages);

        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');

        if ($tpu) {
            $tpuu = new MetTiposUsuariosController;
            return $tpuu->MetEditarTipoUsuario($request, $tpuid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de tipo de usuario válido'
            ]);
        }
    }

    public function ValEliminarTipoUsuario($tpuid)
    {
        $tpu = tputiposusuarios::where('tpuid', $tpuid)->first('tpuid');

        if ($tpu) {
            $tpud = new MetTiposUsuariosController;
            return $tpud->MetEliminarTipoUsuario($tpuid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de tipo de usuario válido'
            ]);
        }
    }

    public function ValListarTiposUsuarios($empid)
    {
        $emp = empempresas::where('empid', $empid)->first('empid');

        if ($emp) {
            $tpu = new MetTiposUsuariosController;
            return $tpu->MetObtenerListaTiposUsuarios($empid);
        }else{
            return response()->json([
                'respuesta' => false,
                'mensaje'   => 'Ingrese un ID de empresa válido'
            ]);
        }
    }
}
