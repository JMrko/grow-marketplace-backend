<?php

namespace App\Http\Controllers\Metodos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalvacionController extends Controller
{
    public function Salvacion()
    {

        return response()->json([
            'link' => "https://pricing-backend.softys-leadcorporate.com/Excels/MarketPlaces-F30702022XA.xlsx"
        ]);

    }
}
