<?php

namespace App\Http\Controllers\Validaciones\MarketPlaces;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Metodos\MarketPlaces\MetObtenerMarketPlacesController;

class ValObtenerMarketPlacesController extends Controller
{
    public function ValObtenerMarketPlaces(Request $request)
    {
        $obtMarketPlaces = new MetObtenerMarketPlacesController;
        return $obtMarketPlaces->MetObtenerMarketPlaces($request);
    }
}
