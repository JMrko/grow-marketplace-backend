<?php

namespace App\Http\Controllers\Metodos\ETL;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\pagpaginas;
use App\Models\fecfechas;
use App\Models\pdpproductosdatospaginas;
use DateTime;
use Goutte\Client;

class MetEtlObtenerDatosPaginasController extends Controller
{
    public function validarDataPorFecha($pagid=0, $eliminarData=false, $mercadolibre=false)
    {
        date_default_timezone_set("America/Lima");
        $fecfechaDate = new DateTime();
        $anioActual = date('Y');
        $mesActual = date('m');
        $diaActual = date('d');
        $mesActualTexto = date('F');
        $diaActualTexto = date('l');
        $mesActualAbreviacion = date('M');

        $fecfecha = fecfechas::where('fecanionumero',$anioActual)
                                ->where('fecmesnumero',$mesActual)
                                ->where('fecdianumero',$diaActual)
                                ->first(['fecid']);
       
        $fecid = 0;
        if ($fecfecha) {
            $fecid = $fecfecha->fecid;
            if($eliminarData == true){
                if ($mercadolibre == true) {
                    dtpdatospaginas::where('pagid',$pagid)
                                ->where('fecid',$fecid)
                                ->where('dtpmercadolibre',$mercadolibre)
                                ->delete();
                }else{
                    dtpdatospaginas::where('pagid',$pagid)
                    ->where('fecid',$fecid)
                    ->delete();
                }
               
            }
        }else{
            $nuevaFechaActual = new fecfechas();
            $nuevaFechaActual->fecfecha = $fecfechaDate;
            $nuevaFechaActual->fecmesabreviacion = $mesActualAbreviacion;
            $nuevaFechaActual->fecdianumero = $diaActual;
            $nuevaFechaActual->fecmesnumero = $mesActual;
            $nuevaFechaActual->fecanionumero = $anioActual;
            $nuevaFechaActual->fecmestexto = $mesActualTexto;
            $nuevaFechaActual->fecdiatexto = $diaActualTexto;
            if($nuevaFechaActual->save()){
                $fecid = $nuevaFechaActual->fecid;
            }
        }
        return $fecid;
    }

    public function obtenerUnidadMedida($nombreProducto)
    {
        $unidades = array(
            (object)
            [
                'nombre' => 'mts',
                'valor'  => 'Metros'
            ],
            (object)
            [
                'nombre' => 'metro',
                'valor'  => 'Metros'
            ],
            (object)
            [
                'nombre' => 'paquete',
                'valor'  => 'Paquete'
            ],
            (object)
            [
                'nombre' => 'paquete',
                'valor'  => 'Paquete'
            ],
            (object)
            [
                'nombre' => ' lts',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => ' lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '1lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '2lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '3lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '4lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '5lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '6lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '7lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '8lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '9lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '0lt',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => 'litro',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => 'litros',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => 'ml',
                'valor'  => 'Mililitros'
            ],
            (object)
            [
                'nombre' => 'unidades',
                'valor'  => 'Unidades'
            ],
            (object)
            [
                'nombre' => 'kg',
                'valor'  => 'Kilogramos'
            ],
            (object)
            [
                'nombre' => 'rollos',
                'valor'  => 'Rollos'
            ],
            (object)
            [
                'nombre' => ' u',
                'valor'  => 'Unidades'
            ],
            (object)
            [
                'nombre' => ' bidón',
                'valor'  => 'Bidones'
            ],
            (object)
            [
                'nombre' => ' caja',
                'valor'  => 'Cajas'
            ],
            (object)
            [
                'nombre' => 'cm',
                'valor'  => 'Centimetros'
            ],
            (object)
            [
                'nombre' => '1L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '2L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '3L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '4L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '5L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '6L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '7L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '8L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '9L',
                'valor'  => 'Litros'
            ],
            (object)
            [
                'nombre' => '0L',
                'valor'  => 'Litros'
            ],
        );

        foreach ($unidades as $unidad) {
            if (stristr($nombreProducto,$unidad->nombre)) {
                $dtpunidadmedida = $unidad->valor;
                break;
            }else{
                $dtpunidadmedida = null;
            }   
        }
        return $dtpunidadmedida;
    }

    public function obtenerProId($nombre, $sku, $pagid, $dtpid, $imagen = null)
    {
        $dtp = dtpdatospaginas::where('dtpnombre', $nombre)
                                    ->where('dtpsku', $sku)
                                    ->where('pagid', $pagid)
                                    ->where('dtpid', "!=", $dtpid)
                                    ->where('proid', "!=", null )
                                    ->where('dtpimagen', $imagen)
                                    ->first([
                                        'proid',
                                        'dtpskuhomologado'
                                    ]);
        if ($dtp) {
            $dtpe = dtpdatospaginas::find($dtpid);
            $dtpe->proid         = $dtp->proid;
            $dtpe->skuhomologado = $dtp->dtpskuhomologado;
            $dtpe->update();

            $pdpc        = new pdpproductosdatospaginas();
            $pdpc->proid = $dtp->proid;
            $pdpc->dtpid = $dtpid;
            $pdpc->empid = 1;
            $pdpc->save();
        }
    }
    
    public function obtenerPrecioPlano($precio)
    {
        if (stristr($precio,'.')) {
            $precioPlano = str_replace(array("."), '', $precio);
        }else if (stristr($precio,',')) {
            $precioPlano = str_replace(array(","), '.', $precio);
        }else{
            $precioPlano = $precio;
        }
        return $precioPlano;
    }

    public function MetAlertasPaginas()
    {
        $arrayPaginas = array();
        date_default_timezone_set("America/Lima");
        $fecfechaDate = new DateTime();
        $anioActual = date('Y');
        $mesActual = date('m');
        $diaActual = date('d');

        $fecfecha = fecfechas::where('fecanionumero',$anioActual)
                                ->where('fecmesnumero',$mesActual)
                                ->where('fecdianumero',$diaActual)
                                ->first(['fecid']);
        
        $fecid = $fecfecha->fecid;

        $paginasFechaActual = dtpdatospaginas::join('pagpaginas as pag','pag.pagid','dtpdatospaginas.pagid')
                                    ->where('fecid', $fecid)
                                    ->distinct('pagid')
                                    ->get(['dtpdatospaginas.pagid','pag.pagnombre']);
        // dd($paginasFechaActual);
        $paginas = pagpaginas::get(['pagid','pagnombre']);

        foreach ($paginas as $key => $pagina) {
            $pag = $pagina->pagnombre;
            foreach ($paginasFechaActual as $paginaFA) {
                if ($pag == $paginaFA->pagnombre) {
                   unset($paginas[$key]);
                }   
            } 
        }
        
        foreach ($paginas as $pag) {
            $arrayPaginas[]['pagnombre'] = $pag->pagnombre;
        }
       
        return response()->json([
            'datos' => $arrayPaginas
        ]);
    }

    public function MetObtenerArcalauquen(Client $client)
    {
        $pagId = 1;
        $tpmid = 1;
        $dtpsigv = true;
        $descuentoProducto = 0;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/15-papel-higienico?page=1',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/16-toallas?page=1',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/8-detergentes-desinfectantes-y-jabones?page=1',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón, Alcohol, Lavalozas, Limpiavidrios, Desengrasante'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/4-dispensadores?page=1',
                'categoria'             => 'Dispensador',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/19-servilletas?page=1',
                'categoria'             => 'Servilleta',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/20-panuelos-desechables?page=1',
                'categoria'             => 'Pañuelo',
                'palabraclave'          => 'Pañuelo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/17-sabanillas?page=1',
                'categoria'             => 'Sabanilla',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/18-panos-de-limpieza?page=1',
                'categoria'             => 'Paños',
                'palabraclave'          => 'Paños de limpieza'
            ]
        );
        
        if($this->validarDataPorFecha(1, true)){
            foreach ($categoriasLink as $categoriaLink) { 
                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURLPages);
                $posicion = $crawler->filter(".page-list > li")->count()-2;
                $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i){
                    $nuevaURLPage = explode('=', $paginaURLPages);
                    $stringSeleccionado = $nuevaURLPage[0];
                    $paginaURL = "$stringSeleccionado=$i";
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $crawler->filter("[class='h1 page-title']")->first()->text();
                    $pagina = $i;

                    $crawler->filter(".js-product-miniature-wrapper")->each(function($node) use($pagina, $tituloCategoria, $pagId, $tpmid, $dtpsigv, $descuentoProducto, $palabraclave){
                        $imagenProducto = $node->filter(".product-thumbnail > img")->attr('data-src');
                        $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                        $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                        $precioProducto = $node->filter("[class='product-price-and-shipping']")->text();
                        $precioString = explode("$",$precioProducto);
                        $precioStringFinal = trim($precioString[0]);
                        $precioPlano = $this->obtenerPrecioPlano($precioStringFinal);
                        $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                        $descProducto = $node->filter(".product-description-short")->text();
                        $stockProducto = $node->filter("[class='product-availability d-block']")->text();
                        $skuProducto = $node->filter("[class='product-reference text-muted']")->text();
                        $ofertaProducto = $node->filter("[class='product-flag on-sale']")->text('¡Sin Oferta!');
                        
                        
                        $fecid = $this->validarDataPorFecha(1);
                    
                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->fecid           = $fecid;
                        $dtpdatospaginas->pagid           = $pagId;
                        $dtpdatospaginas->tpmid           = $tpmid;
                        $dtpdatospaginas->dtpnombre       = $nombreProducto;
                        $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                        $dtpdatospaginas->dtpprecioactual = $precioPlano;
                        $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                        $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                        $dtpdatospaginas->dtpurl          = $urlProducto;
                        $dtpdatospaginas->dtpimagen       = $imagenProducto;
                        $dtpdatospaginas->dtpdesclarga    = $descProducto;
                        $dtpdatospaginas->dtppagina       = $pagina;
                        $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                        $dtpdatospaginas->dtpstock        = $stockProducto;
                        $dtpdatospaginas->dtpsku          = $skuProducto;
                        $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;
                        $dtpdatospaginas->dtpsigv         = $dtpsigv;
                        $dtpdatospaginas->dtppalabraclave = $palabraclave;
                        
                        if($dtpdatospaginas->save()){
                           $this->obtenerProId($nombreProducto, $skuProducto, $pagId, $dtpdatospaginas->id, $imagenProducto);
                        }
                    });
                }
            }
        }
    }

    public function MetObtenerTork(Client $client)
    {
        $pagId             = 2;
        $tpmid             = 1;
        $dtpsigv           = true;
        $ofertaProducto    = "¡Sin Oferta!";
        $descuentoProducto = 0;
        $categoriasLink    = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/papel-higienico',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/toalla-en-rollo',
                'categoria'             => 'Toalla en rollo',
                'palabraclave'          => 'Toalla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/toalla-interfoliada',
                'categoria'             => 'Toalla Interfoliada',
                'palabraclave'          => 'Toalla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/jabon',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/insumos/servilletas',
                'categoria'             => 'Servilleta',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/sabanilla-medica',
                'categoria'             => 'Sabanilla Medica',
                'palabraclave'          => 'Sabanilla'
            ]
        );
        if($this->validarDataPorFecha(2, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $categoriaLink->categoria;
                $crawler->filter(".product-grid-item")->each(function($node) use($pagId, $tituloCategoria, $tpmid, $dtpsigv, $ofertaProducto, $descuentoProducto, $palabraclave){
                    $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
                    $partesStringImagen = explode("{width}",$imagenProducto);
                    $imagenProductoConcatenado = "$partesStringImagen[0]540$partesStringImagen[1]";
                    $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']")->text();
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                    $precioProducto = $node->filter("[class='money']")->text();
                    $precioString = explode("$",$precioProducto);
                    $precioStringFinal = trim($precioString[1]);
                    $precioPlano = $this->obtenerPrecioPlano($precioStringFinal);
                    $urlProducto = $node->filter(".lazy-image")->attr('href');
                    $urlProductoConcatenado = "https://torkalpormayor.cl$urlProducto";
                    $stockProducto = $node->filter("[class='sticker sticker--sold']")->text('En stock');

                    $fecid = $this->validarDataPorFecha(2);
                    
                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid; 
                    $dtpdatospaginas->dtpnombre       = $nombreProducto;
                    $dtpdatospaginas->dtpprecioactual = $precioPlano;
                    $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpurl          = $urlProductoConcatenado;
                    $dtpdatospaginas->dtpimagen       = $imagenProductoConcatenado; 
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                    $dtpdatospaginas->dtpsigv         = $dtpsigv;
                    $dtpdatospaginas->dtpstock        = $stockProducto;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;

                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    }
                });
            }
        } 
    }

    public function MetObtenerDipisa(Client $client)
    {
        $pagId = 3;
        $tpmid = 1;
        $descuentoProducto = 0;
        $ofertaProducto = "¡Sin Oferta!";
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/papel-higienico/',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/toallas-de-papel/',
                'categoria'             => 'Toallas de Papel',
                'palabraclave'          => 'Toalla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/dispensador/',
                'categoria'             => 'Dispensador',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/sabanilla/',
                'categoria'             => 'Sabanilla',
                'palabraclave'          => 'Sabanilla'
            ],
        );
        if($this->validarDataPorFecha(3, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter("[class='col-md-12 text-center']")->first()->text();

                $crawler->filter("[class='col-md-4 mb50']")->each(function($node) use($tituloCategoria, $pagId, $tpmid, $paginaURL, $descuentoProducto, $ofertaProducto,$palabraclave){
                    $imagenProducto = $node->filter(".box-contenido > img")->attr('src');
                    $nombrePrecioProducto = $node->filter("h5")->text('0');
                    // dd($nombrePrecioProducto);
                    if ($nombrePrecioProducto !== '') {
                        $nombreProducto = explode ("Un.", $nombrePrecioProducto);
                        $precioProducto = explode("Precio:", $nombrePrecioProducto);
                        $precioString = explode("$",$precioProducto[1]);
                        $precioString2 = explode("+", $precioString[1]);
                        $precioStringFinal = trim($precioString2[0]);
                        $precioPlano = $this->obtenerPrecioPlano($precioStringFinal);
                    }else{
                        $precioPlano = '';
                        $nombreProducto = '';
                    }
                    $marcaProducto = $node->filter(".box-contenido > h4")->text();
                    $skuProducto = $node->filter("p > span")->text();
                    if ($nombrePrecioProducto !== '') {
                        $nombreCompleto = $marcaProducto .' '. $nombreProducto[0];
                        $igvProducto = stristr($precioProducto[1],'IVA') ? true : false;
                    }else{
                        $nombreCompleto = '';
                        $igvProducto = false;
                    }
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreCompleto);

                    $fecid = $this->validarDataPorFecha(3);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid;
                    $dtpdatospaginas->dtpnombre       = $nombreCompleto;
                    $dtpdatospaginas->dtpimagen       = $imagenProducto;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpmarca        = $marcaProducto;
                    $dtpdatospaginas->dtpsku          = $skuProducto;
                    $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                    $dtpdatospaginas->dtpprecioactual = $precioPlano;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;  
                    $dtpdatospaginas->dtpsigv         = $igvProducto;
                    $dtpdatospaginas->dtpurl          = $paginaURL;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;
                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, $skuProducto, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    }
                });
            }
        }
    }

    public function MetObtenerAvalco(Client $client)
    {
        $pagId = 4;
        $tpmid = 1;
        $dtpsigv = true;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/167-papel-higienico?page=1',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/165-papel-higienico-jumbo?page=1',
                'categoria'             => 'Papel Higiénico Jumbo',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/166-toallas-interfoliadas?page=1',
                'categoria'             => 'Toallas Interfoliadas',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/61-papeles-higienicos-y-toallas-de-papel?page=1',
                'categoria'             => 'Papel Higienico y Toallas de Papel',
                'palabraclave'          => 'Toalla de papel, Papel Higiénico, Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/73-jabones?page=1',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/126-servilletas-de-papel?page=1',
                'categoria'             => 'Servilleta',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/22-dispensadores-de-jabon?page=1',
                'categoria'             => 'Dispensador de Jabon',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/23-dispensadores-de-papel?page=1',
                'categoria'             => 'Dispensador de Papel',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/139-alcohol-desnaturalizado?page=1',
                'categoria'             => 'Alcohol Desnaturalizado',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/131-alcohol-etilico?page=1',
                'categoria'             => 'Alcochol Etilico',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/129-alcohol-gel?page=1',
                'categoria'             => 'Alcohol Gel',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/130-alcohol-isopropilico?page=1',
                'categoria'             => 'Alcohol Isopropilico',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/40-desengrasantes?page=1',
                'categoria'             => 'Desengrasante',
                'palabraclave'          => 'Desengrasante'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/29-limpiadores-multiuso?page=1',
                'categoria'             => 'Limpiadores multiuso',
                'palabraclave'          => 'Limpiavidrios, Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/64-implementos-limpieza?page=1',
                'categoria'             => 'Implementos de limpieza',
                'palabraclave'          => 'Paños'
            ],
        );
        if($this->validarDataPorFecha(4, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURLPages);
                $posicion = $crawler->filter(".page-list > li")->count()-2;
                $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i)
                {
                    $nuevaURLPage = explode('=', $paginaURLPages);
                    $stringSeleccionado = $nuevaURLPage[0];
                    $paginaURL = "$stringSeleccionado=$i";
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $crawler->filter("[class='page-heading js-category-page']")->first()->text();
                    $pagina = $i;
                    
                    $crawler->filter("[class='product-miniature product-style js-product-miniature']")->each(function($node) use($tituloCategoria, $pagina, $pagId, $tpmid, $dtpsigv,$palabraclave){
                        $imagenProducto = $node->filter(".product-cover-link > img")->attr('src');
                        $nombreProducto = $node->filter(".product-name")->text();
                        $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                        $precioActualProducto = $node->filter("[class='price product-price']")->text();
                        $precioString = explode("$",$precioActualProducto);
                        $precioStringFinal = trim($precioString[0]);
                        $precioActualPlano = $this->obtenerPrecioPlano($precioStringFinal);
                        $precioRegularProducto = $node->filter("[class='regular-price']")->text($precioStringFinal);
                        $precioregularString = explode("$",$precioRegularProducto);
                        $precioregularStringFinal = trim($precioregularString[0]);
                        $precioRealPlano = $this->obtenerPrecioPlano($precioregularStringFinal);
                        $urlProducto = $node->filter(".product-name > a")->attr('href');
                        $stringSkuProducto = $node->filter(".second-block > h4")->text();
                        $skuProducto = explode ("Ref:", $stringSkuProducto);
                        $stockProducto = $node->filter(".available")->text('-');
                        $descProducto = $node->filter(".product-description-short")->text();
                        $descuentoProducto = $node->filter("[class='product-flag discount']")->text('0');
                        $ofertaProducto = $node->filter("[class='product-flag on-sale']")->text('¡Sin Oferta!');

                        $fecid = $this->validarDataPorFecha(4);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid           = $pagId;
                        $dtpdatospaginas->fecid           = $fecid;    
                        $dtpdatospaginas->tpmid           = $tpmid;
                        $dtpdatospaginas->dtpnombre       = $nombreProducto;
                        $dtpdatospaginas->dtpimagen       = $imagenProducto;
                        $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                        $dtpdatospaginas->dtpurl          = $urlProducto;
                        $dtpdatospaginas->dtpprecioactual = $precioActualPlano;
                        $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                        $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                        $dtpdatospaginas->dtppagina       = $pagina;
                        $dtpdatospaginas->dtpstock        = $stockProducto;
                        $dtpdatospaginas->dtpsku          = $skuProducto[1];
                        $dtpdatospaginas->dtpdesclarga    = $descProducto;
                        $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                        $dtpdatospaginas->dtpsigv         = $dtpsigv;
                        $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                        $dtpdatospaginas->dtppalabraclave = $palabraclave;
                        if($dtpdatospaginas->save()){
                            $this->obtenerProId($nombreProducto, $skuProducto[1], $pagId, $dtpdatospaginas->id, $imagenProducto);
                        }
                    });
                }
            }

        }
    }

    public function MetObtenerDilen(Client $client)
    {
        $pagId = 5;
        $tpmid = 1;
        $descuentoProducto = 0;
        $ofertaProducto = "¡Sin Oferta!";
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/toalla-de-papel/',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/jabones/',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-bajo-metraje/',
                'categoria'             => 'Dispensador de Papel Higienico de Bajo Metraje',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-bajo-metraje-interfoliado/',
                'categoria'             => 'Dispensador de Papel Higienico de Bajo Metraje Interfoliado',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-alto-metraje/',
                'categoria'             => 'Dispensador de Papel Higienico de Alto Metraje',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/servilleta/dispensador-servilleta-express/',
                'categoria'             => 'Servilleta Express',
                'palabraclave'          => 'Dispensador'
            ],(object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/servilleta/dispensador-servilleta-mesa/',
                'categoria'             => 'Servilleta Mesa',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/sabanillas/dispensador-sabanillas/',
                'categoria'             => 'Dispensador de Sabanilla',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/accesorios-de-bano/cobertor-w-c/dispensador-cobertor-w-c/',
                'categoria'             => 'Dispensador Cobertor W.C',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/jabones/jabon-rellenable/dispensador-jabon-rellenable/',
                'categoria'             => 'Dispensador de Jabon Rellenable',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/jabones/jabon-multiflex/dispensador-jabon-multiflex/',
                'categoria'             => 'Dispensador de Jabon Multiflex',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/panos-de-limpieza/dispensador-panos-de-limpieza/',
                'categoria'             => 'Dispensador de Panos de Limpieza',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/servilleta/',
                'categoria'             => 'Servilleta',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/sabanillas/',
                'categoria'             => 'Sabanilla',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/panal-para-adultos/',
                'categoria'             => 'Panal para adultos',
                'palabraclave'          => 'Pañal'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/panos-de-limpieza/',
                'categoria'             => 'Panos de Limpieza',
                'palabraclave'          => 'Paños de limpieza'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/higiene-y-cuidados/alcohol-gel/',
                'categoria'             => 'Alcohol Gel',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/lavalozas/',
                'categoria'             => 'Lavalozas',
                'palabraclave'          => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/limpiavidrios/',
                'categoria'             => 'Limpiavidrios',
                'palabraclave'          => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/desengrasante/',
                'categoria'             => 'Desengrasantes',
                'palabraclave'          => 'Desengrasante'
            ],                    
        );
        if($this->validarDataPorFecha(5, true)){
            foreach ($categoriasLink as $categoriaLink) {
                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter(".title")->text();

                $crawler->filter(".isotope-item")->each(function($node) use($tituloCategoria, $pagId, $tpmid,$descuentoProducto,$ofertaProducto,$palabraclave){
                    $imagenProducto = $node->filter("[class='scale-with-grid wp-post-image']")->attr('src');
                    $nombreProducto = $node->filter(".desc > h4")->text();
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                    $urlProducto = $node->filter(".image_wrapper > a")->attr('href');
                    $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
                    $precioString = explode("$",$precioProducto);
                    $precioStringFinal = trim($precioString[1]);
                    $precioPlano = $this->obtenerPrecioPlano($precioStringFinal);
                    $stockProducto = $node->filter(".soldout")->text("Stock");

                    $fecid = $this->validarDataPorFecha(5);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid;
                    $dtpdatospaginas->dtpnombre       = $nombreProducto;
                    $dtpdatospaginas->dtpurl          = $urlProducto;
                    $dtpdatospaginas->dtpimagen       = $imagenProducto;
                    $dtpdatospaginas->dtpprecioactual = $precioPlano;
                    $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                    $dtpdatospaginas->dtpstock        = $stockProducto;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;
                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    }
                });
            }
        }
    }

    public function MetObtenerSodimac(Client $client)
    {
        $pagId = 6;
        $tpmid = 1;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=papel%2520higienico',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico, Pañuelo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=toalla',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=servilleta&currentpage=1',
                'categoria'             => 'Servilleta',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850181?currentpage=1&=&f.product.attribute.Tipo=dispensadores%2520de%2520jabon',
                'categoria'             => 'Dispensador de Jabon',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=dispensador%20de%20servilleta?currentpage=1',
                'categoria'             => 'Dispensador de Servilleta',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/scat963514/Limpieza?Ntt=dispensadores&sTerm=dispensadores&sType=category&sScenario=BTP_CAT_dispensadores&currentpage=1&f.product.attribute.Tipo=dispensador%2520papel%2520higienico',
                'categoria'             => 'Dispensador de Papel Higienico',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/scat963514/Limpieza?Ntt=jabones%20alcohol&sTerm=jabones&sType=category&sScenario=BTP_CAT_jabones%20alcohol&currentpage=1&f.product.attribute.Tipo=jabon',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat9230001/Insumos-Medicos?currentpage=1',
                'categoria'             => 'Sabanillas',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat11540001/Proteccion-Sanitaria?currentpage=1&=&f.product.attribute.Tipo=alcohol%3A%3Aalcohol%2520gel',
                'categoria'             => 'Alcohol Gel',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850292/Limpiadores-de-cocina?currentpage=1&=&f.product.attribute.Tipo=lavalozas',
                'categoria'             => 'Lavalozas',
                'palabraclave'          => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850294/Limpiadores-Especificos?currentpage=1&=&f.product.attribute.Tipo=limpiavidrios',
                'categoria'             => 'Limpiavidrios',
                'palabraclave'          => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=desengrasantes&currentpage=1&f.product.attribute.Tipo=desengrasante',
                'categoria'             => 'Desengrasantes',
                'palabraclave'          => 'Desengrasante'
            ],
        );
        if($this->validarDataPorFecha(6, true)){
            foreach ($categoriasLink as $categoriaLink) {
                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter("[class='jsx-4278284191 page-item page-index ']")->last()->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i){
                    $nuevaURLPage = explode('currentpage=1', $paginaURLPages);
                    $primerStringSeleccionado = $nuevaURLPage[0];
                    if ($nuevaURLPage[1]) {
                        $segundoStringSeleccionado = $nuevaURLPage[1];
                        $stringSeleccionado = "$primerStringSeleccionado"."currentpage=$i$segundoStringSeleccionado";               
                    }else{
                        $stringSeleccionado = "$primerStringSeleccionado"."currentpage=$i";
                    }
                    $paginaURL = $stringSeleccionado;
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $crawler->filter("[class='jsx-245626150 category-title']")->text($categoriaLink->categoria);
                    $pagina = $i;

                    $crawler->filter("[class='jsx-411745769 product ie11-product-container']")->each(function($node) use($tituloCategoria, $pagina, $pagId, $tpmid, $palabraclave){
                        $imagenProducto = $node->filter("[class='image-contain ie11-image-contain  __lazy']")->attr('data-src');
                        $nombreProducto = $node->filter("[class='jsx-411745769 product-title']")->text();
                        $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                        $marcaProducto = $node->filter("[class='jsx-411745769 product-brand']")->text();
                        $urlProducto = $node->filter("[class='jsx-4282314783 link link-primary ']")->attr('href');
                        $precioActualProducto = $node->filter("[class='jsx-4135487716']")->first()->text();
                        $precioActualString = explode("$",$precioActualProducto);
                        $precioActualStringFinal = trim($precioActualString[1]);
                        $precioRealProducto = $node->filter("[class='jsx-4135487716']")->last()->text("0");
                        $precioRealString = explode("$",$precioRealProducto);
                        $precioRealStringFinal = trim($precioRealString[1]);
                        $stockProducto = $node->filter("[class='jsx-2799553099 withdrawl-info']")->text();
                        $envioProducto = $node->filter("[class='jsx-2799553099 dispatch-info']")->text();
                        $ofertaProducto = $node->filter("[class='jsx-585964327 main gridView CMR']")->text('Sin oferta');
                        $fecid = $this->validarDataPorFecha(6);
                        if ($precioActualStringFinal < $precioRealStringFinal) {
                            $descuentoProducto = $precioRealStringFinal - $precioActualStringFinal;
                        }else{
                            $descuentoProducto = '0';
                        }
                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid           = $pagId;
                        $dtpdatospaginas->fecid           = $fecid;
                        $dtpdatospaginas->tpmid           = $tpmid;
                        $dtpdatospaginas->dtpnombre       = $nombreProducto;
                        $dtpdatospaginas->dtpurl          = $urlProducto;
                        $dtpdatospaginas->dtpimagen       = $imagenProducto;
                        $dtpdatospaginas->dtpprecioactual = $precioActualStringFinal;
                        $dtpdatospaginas->dtpprecioreal   = $precioRealStringFinal;
                        $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                        $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                        $dtpdatospaginas->dtpmarca        = $marcaProducto;
                        $dtpdatospaginas->dtppagina       = $pagina;
                        $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                        $dtpdatospaginas->dtpstock        = $stockProducto;
                        $dtpdatospaginas->dtpmercadoenvio = $envioProducto;
                        $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                        $dtpdatospaginas->dtppalabraclave = $palabraclave;
                        if($dtpdatospaginas->save()){
                            $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                         }                       
                    });
                }
            }
        }
    }

    public function MetObtenerDpronto(Client $client)
    {
        $pagId = 7;
        $tpmid = 1;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/dispensadores-de-jabon/',
                'categoria'             => 'Dispensador de Jabon',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/dispensadores-de-jabon-papel-hig-toalla/',
                'categoria'             => 'Dispensador de Jabon Papel Hig. Toalla',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/jabones/',
                'categoria'             => 'Jabones',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/papeles-higienicos/',
                'categoria'             => 'Papeles Higienicos',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/toallas-de-papel-y-servilletas/',
                'categoria'             => 'Toallas de Papel y Servilletas',
                'palabraclave'          => 'Servilleta, Toalla de papel, Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/lavalozas-y-desengrasantes/',
                'categoria'             => 'Lavalozas y Desengrasantes',
                'palabraclave'          => 'Lavalozas, Desengrasante'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/limpiavidrios/',
                'categoria'             => 'Limpiavidrios',
                'palabraclave'          => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/desinfectantes-sanitizantes-enzimaticos/',
                'categoria'             => 'Desinfectantes Sanitizantes Enzimaticos',
                'palabraclave'          => 'Alcohol'
            ],
        );

        if($this->validarDataPorFecha(7, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $categoriaLink->categoria;
                
                $crawler->filter("[class='product-small box ']")->each(function($node) use($tituloCategoria, $pagId, $tpmid, $palabraclave){
                    $imagenProducto = $node->filter(".image-zoom > a > img")->attr('data-src');
                    $nombreProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->text();
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                    $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
                    $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
                    $preciorealString = explode("$",$precioProducto);
                    $preciorealStringFinal = trim($preciorealString[1]);
                    $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);
                    $precioactualProducto = $node->filter("[class='woocommerce-Price-amount amount']")->last()->text($precioRealPlano);
                    $precioactualString = explode("$",$precioactualProducto);
                    $precioactualStringFinal = trim($precioactualString[1]);
                    $precioActualPlano = $this->obtenerPrecioPlano($precioactualStringFinal);

                    $stockProducto = $node->filter("[class='out-of-stock-label']")->text("Stock");
                    if ($precioActualPlano <= $precioRealPlano) {
                        $descuentoProducto = $precioRealPlano - $precioActualPlano;
                    }
                    if ($descuentoProducto > 0) {
                        $ofertaProducto = "¡Con Oferta!";
                    }else{
                        $ofertaProducto = "¡Sin Oferta!";
                    }

                    $fecid = $this->validarDataPorFecha(7);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid; 
                    $dtpdatospaginas->dtpnombre       = $nombreProducto;
                    $dtpdatospaginas->dtpurl          = $urlProducto;
                    $dtpdatospaginas->dtpimagen       = $imagenProducto;
                    $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                    $dtpdatospaginas->dtpprecioactual = $precioActualPlano;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;
                    $dtpdatospaginas->dtpstock        = $stockProducto;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;
                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    }  
                });
            }
        }
    }

    public function MetObtenerComcer(Client $client)
    {
        $pagId = 8;
        $tpmid = 1;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/papeles-higienicos-formato-hogar-y-jumbo/',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/toalla-de-papel/',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/sabanillas/',
                'categoria'             => 'Sabanillas',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/servilletas/',
                'categoria'             => 'Servilletas',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/dispensadores/',
                'categoria'             => 'Dispensadores',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/jabones/',
                'categoria'             => 'Jabon Gel',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/panos/',
                'categoria'             => 'Panos',
                'palabraclave'          => 'Paños de limpieza'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/proteccion-covid-19/jabon-y-alcohol-gel/',
                'categoria'             => 'Jabon y Alcohol Gel',
                'palabraclave'          => 'Jabón, Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/detergentes/lavalozas/',
                'categoria'             => 'Lavalozas y Desengrasantes',
                'palabraclave'          => 'Lavalozas, Desengrasante'
            ],
        );
        if($this->validarDataPorFecha(8, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter("[class='woocommerce-products-header__title page-title']")->text();

                $crawler->filter(".products > li")->each(function($node) use($tituloCategoria, $pagId, $tpmid, $palabraclave){
                    $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
                    $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']")->text();
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                    $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
                    $preciorealProducto = $node->filter("[class='woocommerce-Price-amount amount']")->first()->text();
                    $preciorealString = explode("$",$preciorealProducto);
                    $preciorealStringFinal = trim($preciorealString[1]);
                    $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);
                    // $preciorealStringFinalSinPunto = str_replace(array("."), '', $preciorealStringFinal);
                    $precioactualProducto = $node->filter("[class='woocommerce-Price-amount amount']")->last()->text($precioRealPlano);
                    $precioactualString = explode("$",$precioactualProducto);
                    $precioactualStringFinal = trim($precioactualString[1]);
                    $precioActualPlano = $this->obtenerPrecioPlano($precioactualStringFinal);
                    // $precioactualStringFinalSinPunto = str_replace(array("."), '', $precioactualStringFinal);
                    if ($precioActualPlano <= $precioRealPlano) {
                        $descuentoProducto = $precioRealPlano - $precioActualPlano;
                    }
                    if ($descuentoProducto > 0) {
                        $ofertaProducto = "¡Con Oferta!";
                    }else{
                        $ofertaProducto = "¡Sin Oferta!";
                    }

                    $fecid = $this->validarDataPorFecha(8);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid;
                    $dtpdatospaginas->dtpnombre       = $nombreProducto;
                    $dtpdatospaginas->dtpurl          = $urlProducto;
                    $dtpdatospaginas->dtpimagen       = $imagenProducto;
                    $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                    $dtpdatospaginas->dtpprecioactual = $precioActualPlano;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;
                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    } 
                });
            }
        }
    }

    public function MetObtenerOfimaster(Client $client)
    {
        $pagId = 9;
        $tpmid = 1;
        $descuentoProducto = 0;
        $ofertaProducto = "¡Sin Oferta!";
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/papel-tissue/papel-higienico?page=1',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/papel-tissue/toalla-de-papel?page=1',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/quimicos-de-limpieza/jabones?page=1',
                'categoria'             => 'Jabones',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-aromas?page=1',
                'categoria'             => 'Dispensador de Aromas',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-jabon?page=1',
                'categoria'             => 'Dispensador de Jabon',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-papel-higiienico?page=1',
                'categoria'             => 'Dispensador de Papel Higienico',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-toalla-de-papel?page=1',
                'categoria'             => 'Dispensador de Toalla',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/papel-tissue/servilletas?page=1',
                'categoria'             => 'Servilletas',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=sabanilla&page=1',
                'categoria'             => 'Sabanillas',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=pa%C3%B1o&page=1',
                'categoria'             => 'Paños',
                'palabraclave'          => 'Paños'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=pa%C3%B1uelo%7D&page=1',
                'categoria'             => 'Pañuelos',
                'palabraclave'          => 'Pañuelo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=alcohol&page=1',
                'categoria'             => 'Alcohol',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=lavaloza&page=1',
                'categoria'             => 'Lavalozas',
                'palabraclave'          => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=limpiavidrio&page=1',
                'categoria'             => 'Limpiavidrios',
                'palabraclave'          => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=desengrasante&page=1',
                'categoria'             => 'Desengrasantes',
                'palabraclave'          => 'Desengrasante'
            ],

        );

        if($this->validarDataPorFecha(9, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter('.count > span')->last()->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i){

                    $nuevaURLPage = explode('page=', $paginaURLPages);
                    $stringSeleccionado = $nuevaURLPage[0];
                    $paginaURL = "$stringSeleccionado"."page=$i";

                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $categoriaLink->categoria;
                    $pagina = $i;
                    
                    $crawler->filter("[class='product-block']")->each(function($node) use($tituloCategoria, $pagina, $pagId, $tpmid, $descuentoProducto, $ofertaProducto, $palabraclave){
                        $imagenProducto = $node->filter("[class='img-fluid']")->attr('src');
                        $nombreProducto = $node->filter("[class='brand-name trsn']")->text();
                        $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                        $urlProducto = $node->filter(".product-block > a")->attr('href');
                        $urlProductoConcatenado = "https://www.ofimaster.cl/$urlProducto";
                        $precioProducto = $node->filter("[class='block-price']")->text();
                        $precioString = explode("$",$precioProducto);
                        $precioString2 = explode("CLP",$precioString[1]);
                        $precioStringFinal = trim($precioString2[0]);
                        $precioPlano = $this->obtenerPrecioPlano($precioStringFinal);
                        $marcaProducto = $node->filter("[class='brand']")->text('-');

                        $fecid = $this->validarDataPorFecha(9);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid           = $pagId;
                        $dtpdatospaginas->fecid           = $fecid;
                        $dtpdatospaginas->tpmid           = $tpmid;
                        $dtpdatospaginas->dtpnombre       = $nombreProducto;
                        $dtpdatospaginas->dtpurl          = $urlProductoConcatenado;
                        $dtpdatospaginas->dtpimagen       = $imagenProducto;
                        $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                        $dtpdatospaginas->dtpprecioactual = $precioPlano;
                        $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                        $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                        $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                        $dtpdatospaginas->dtppagina       = $pagina;
                        $dtpdatospaginas->dtpmarca        = $marcaProducto;
                        $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                        $dtpdatospaginas->dtppalabraclave = $palabraclave;
                        if($dtpdatospaginas->save()){
                            $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                        }   
                    });
                }
            }
        }
    }

    public function MetObtenerDaos(Client $client)
    {
        $pagId = 10;        
        $tpmid = 1;
        $descuentoProducto = 0;
        $ofertaProducto = "¡Sin Oferta!";
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/15-papel-higienico',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/17-toalla-de-papel',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/21-lavalozas',
                'categoria'             => 'Lavalozas',
                'palabraclave'          => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/70-jabon-liquido',
                'categoria'             => 'Jabon Liquido',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/71-jabon-en-barra',
                'categoria'             => 'Jabon Barra',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/22-antigrasa',
                'categoria'             => 'Desengrasante',
                'palabraclave'          => 'Desengrasante'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/27-limpiadores',
                'categoria'             => 'Limpiavidrios',
                'palabraclave'          => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/101-alcohol-gel',
                'categoria'             => 'Alcohol Gel',
                'palabraclave'          => 'Alcohol'
            ],
        );
        if($this->validarDataPorFecha(10, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter(".page-list > li")->eq(4)->text('1');
                
                for($i=1; $i<=$numeroPaginas; ++$i){

                    $paginaURL = "$paginaURLPages?page=$i";
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $crawler->filter(".h2")->text();
                    $pagina = $i;
                    
                    $crawler->filter("[class='thumbnail-container']")->each(function($node) use($tituloCategoria, $pagina, $pagId, $tpmid,$descuentoProducto,$ofertaProducto,$palabraclave){
                        $imagenProducto = $node->filter("[class='ttproduct-img1']")->attr('src');
                        $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                        $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                        $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                        $preciorealProducto = $node->filter("[class='price']")->text();
                        $preciorealString = explode("$",$preciorealProducto);
                        $preciorealStringFinal = trim($preciorealString[1]);
                        $precioPlano = $this->obtenerPrecioPlano($preciorealStringFinal);

                        $fecid = $this->validarDataPorFecha(10);

                        if ($precioPlano > 0) {
                            $dtpdatospaginas = new dtpdatospaginas();
                            $dtpdatospaginas->pagid           = $pagId;
                            $dtpdatospaginas->fecid           = $fecid;
                            $dtpdatospaginas->tpmid           = $tpmid; 
                            $dtpdatospaginas->dtpnombre       = $nombreProducto;
                            $dtpdatospaginas->dtpurl          = $urlProducto;
                            $dtpdatospaginas->dtpimagen       = $imagenProducto;
                            $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                            $dtpdatospaginas->dtpprecioactual = $precioPlano;
                            $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                            $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                            $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                            $dtpdatospaginas->dtppagina       = $pagina;
                            $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;
                            $dtpdatospaginas->dtppalabraclave = $palabraclave;
                            if($dtpdatospaginas->save()){
                                $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                            } 
                        }
                    });
                }
            }
        }
    }

    public function MetObtenerProvit(Client $client)
    {
        $pagId = 11;
        $tpmid = 1;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/10/papel-higienico',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/12/tollas-en-rollo',
                'categoria'             => 'Toallas en Rollo',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/13/toallas-interfoliadas',
                'categoria'             => 'Toallas Interfoliadas',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/14/sabanillas',
                'categoria'             => 'Sabanillas',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/1/jabon',
                'categoria'             => 'Jabones',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/lineas/1/dispensadores',
                'categoria'             => 'Dispensadores',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/11/servilletas',
                'categoria'             => 'Servilletas',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/3/panos',
                'categoria'             => 'Paños',
                'palabraclave'          => 'Paños'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/alcohol',
                'categoria'             => 'Alcohol',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/lavaloza',
                'categoria'             => 'Lavalozas',
                'palabraclave'          => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/limpiavidrio',
                'categoria'             => 'Limpiavidrios',
                'palabraclave'          => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/desengrasante',
                'categoria'             => 'Desengrasantes',
                'palabraclave'          => 'Desengrasante'
            ],
        );
        if($this->validarDataPorFecha(11, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter(".paginate")->last()->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i){
                    $paginaURL = "$paginaURLPages/9999/0/0/9999/0/9/pagina-$i";
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $categoriaLink->categoria;
                    $pagina = $i;
                    
                    $crawler->filter("[class='grilla']")->each(function($node) use($tituloCategoria, $pagina, $pagId, $tpmid,$palabraclave){
                        $imagenProducto = $node->filter(".imgGrilla > img")->attr('src');
                        $imagenProductoConcatenado = "https://provit.cl/$imagenProducto";
                        $nombreProducto = $node->filter("[class='nombreGrilla']")->text();
                        $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                        $urlProducto = $node->filter("[class='nombreGrilla']")->attr('href');
                        $urlProductoConcatenado = "https://provit.cl/$urlProducto";

                        $precioactualProducto = $node->filter("[class='conDescuento']")->text();
                        $precioactualString = explode("$",$precioactualProducto);
                        $precioactualStringFinal = trim($precioactualString[1]);
                        $precioActualPlano = $this->obtenerPrecioPlano($precioactualStringFinal);

                        $preciorealProducto = $node->filter(".valorGrilla > .antes")->text($precioActualPlano);
                       if (strlen($preciorealProducto) > 8) {
                            $preciorealString = explode("$",$preciorealProducto);
                            $preciorealStringFinal = trim($preciorealString[1]);
                            $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);
                       }else{
                            $precioRealPlano = $precioActualPlano;
                       }
                        
                        if ($precioRealPlano > $precioActualPlano) {
                            $descuentoProducto = $precioRealPlano - $precioActualPlano;
                        }else{
                            $descuentoProducto = 0;
                        }

                        if ($descuentoProducto > 0) {
                            $ofertaProducto = "¡Con Oferta!";
                        }else{
                            $ofertaProducto = "¡Sin Oferta!";
                        }

                        $fecid = $this->validarDataPorFecha(11);
                        
                        if ($precioRealPlano > 0) {
                            $dtpdatospaginas = new dtpdatospaginas();
                            $dtpdatospaginas->pagid           = $pagId;
                            $dtpdatospaginas->fecid           = $fecid;
                            $dtpdatospaginas->tpmid           = $tpmid;
                            $dtpdatospaginas->dtpnombre       = $nombreProducto;
                            $dtpdatospaginas->dtpurl          = $urlProductoConcatenado;
                            $dtpdatospaginas->dtpimagen       = $imagenProductoConcatenado;
                            $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                            $dtpdatospaginas->dtpprecioactual = $precioActualPlano;
                            $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                            $dtpdatospaginas->dtppagina       = $pagina;
                            $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;
                            $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                            $dtpdatospaginas->dtpmecanica     = $ofertaProducto; 
                            $dtpdatospaginas->dtppalabraclave = $palabraclave;
                            if($dtpdatospaginas->save()){
                                $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProductoConcatenado);
                            } 
                        }
                    });
                }
            }
        }
    }

    public function MetObtenerLimpiamas(Client $client)
    {
        $pagId = 12;
        $tpmid = 1;
        $descuentoProducto = 0;
        $ofertaProducto = "¡Sin Oferta!";
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/papel-higienico',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/toalla',
                'categoria'             => 'Toalla de Papel',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/jabon',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/dispensador',
                'categoria'             => 'Dispensador',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/servilleta',
                'categoria'             => 'Servilletas',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/sabanilla',
                'categoria'             => 'Sabanillas',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/pañal',
                'categoria'             => 'Pañales',
                'palabraclave'          => 'Pañal'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/alcohol',
                'categoria'             => 'Alcohol',
                'palabraclave'          => 'Alcohol'
            ],

        );
        if($this->validarDataPorFecha(12, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter(".ui-search-breadcrumb__title")->text();
                
                $crawler->filter("[class='ui-search-result__wrapper']")->each(function($node) use($tituloCategoria, $pagId, $tpmid, $descuentoProducto, $ofertaProducto,$palabraclave){
                    $imagenProducto = $node->filter(".slick-slide > img")->attr('data-src');
                    $nombreProducto = $node->filter("[class='ui-search-item__title']")->text();
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                    $urlProducto = $node->filter("[class='ui-search-item__group__element ui-search-link']")->attr('href');
                    $precioProducto = $node->filter("[class='price-tag-amount']")->text();
                    $precioString = explode("$",$precioProducto);
                    $precioStringFinal = trim($precioString[1]);
                    $precioPlano = $this->obtenerPrecioPlano($precioStringFinal);
                    $envioGratisProducto = $node->filter("[class='ui-search-item__shipping ui-search-item__shipping--free']")->text("Sin envío");

                    $fecid = $this->validarDataPorFecha(12);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid;
                    $dtpdatospaginas->dtpnombre       = $nombreProducto;
                    $dtpdatospaginas->dtpurl          = $urlProducto;
                    $dtpdatospaginas->dtpimagen       = $imagenProducto;
                    $dtpdatospaginas->dtpprecioreal   = $precioPlano;
                    $dtpdatospaginas->dtpprecioactual = $precioPlano;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                    $dtpdatospaginas->dtpenviogratis  = $envioGratisProducto;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;
                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    }   
                });
            }
        }
    }

    public function MetObtenerHygiene(Client $client)
    {
        $pagId = 13;
        $tpmid = 1;
        $descuentoProducto = "";
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/higenicos/',
                'categoria'             => 'Papel Higienico',
                'palabraclave'          => 'Papel Higiénico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/dobladas/',
                'categoria'             => 'Toalla Doblada',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/toallas-rollo/',
                'categoria'             => 'Toalla Rollo',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/wipe/',
                'categoria'             => 'Toalla Wipe',
                'palabraclave'          => 'Toalla de papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/jabones/',
                'categoria'             => 'Jabon',
                'palabraclave'          => 'Jabón'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/otros-papeles/sabanillas-medicas/',
                'categoria'             => 'Sabanillas Medicas',
                'palabraclave'          => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/desengrasantes/',
                'categoria'             => 'Desengrasantes',
                'palabraclave'          => 'Desengrasante'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/accesorios-superficies/panos/',
                'categoria'             => 'Paños',
                'palabraclave'          => 'Paños de limpieza'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/otros-papeles/panuelos-faciales/',
                'categoria'             => 'Pañuelos Faciales',
                'palabraclave'          => 'Pañuelo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/servilletas-gourmet/',
                'categoria'             => 'Servilleta Gourmet',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-mesa/',
                'categoria'             => 'Servilleta Mesa',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-interfoliadas/',
                'categoria'             => 'Servilleta Interfoliada',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilleta-coctel/',
                'categoria'             => 'Servilleta Coctel',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-lunch/',
                'categoria'             => 'Servilleta Lunch',
                'palabraclave'          => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/dispensadores-servilletas/',
                'categoria'             => 'Dispensador de Servilletas',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/higenicos/dispensadores-higienicos/',
                'categoria'             => 'Dispensador Higienico',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/jabones/dispensadores-jabones/',
                'categoria'             => 'Dispensador Jabones',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/dispensadores-toallas/',
                'categoria'             => 'Dispensador Toalla',
                'palabraclave'          => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/incontinencia/incontinencia-hombres/',
                'categoria'             => 'Incontinencia Hombres',
                'producto'              => 'Pañal',
                'palabraclave'          => 'Pañal'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/elementos-proteccion-personal/proteccion-piel/',
                'categoria'             => 'Proteccion Piel',
                'producto'              => 'Alcohol',
                'palabraclave'          => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/lavalozas/',
                'categoria'             => 'Lavalozas',
                'palabraclave'          => 'Lavalozas'
            ],
        );
        if($this->validarDataPorFecha(13, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $palabraclave = $categoriaLink->palabraclave;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $categoriaLink->categoria;

                $crawler->filter(".classic")->each(function($node) use($tituloCategoria, $pagId, $tpmid, $descuentoProducto, $palabraclave){
                    $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
                    $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']")->text();
                    $dtpunidadmedida = $this->obtenerUnidadMedida($nombreProducto);
                    $urlProducto = $node->filter(".product-wrap > a")->attr('href');
                    
                    $precio = $node->filter("[class='price']")->text();
                    //cuando el precio del producto tenga un rango
                    if (strpos($precio,"–")) {
                        $preciorealProducto = $node->filter("[class='price']")->text();
                        $preciorealString = explode("+ IVA",$preciorealProducto);
                        $preciorealStringFinal = str_replace(array("$"), '', $preciorealString[0]);
                        $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);
                        $precioActualPlano = $precioRealPlano;
                    }else{ //no tendra un rango y sera precio unico teniendo en cuenta que pueda estar en oferta
                        $preciorealProducto = $node->filter("[class='woocommerce-Price-amount amount']")->first()->text();
                        $precioactualProducto = $node->filter("[class='woocommerce-Price-amount amount']")->last()->text($preciorealProducto);
                        $precioactualStringFinal = str_replace(array("$"), '', $precioactualProducto);
                        $precioActualPlano = $this->obtenerPrecioPlano($precioactualStringFinal);
                        

                        if ( strpos($preciorealProducto,"–")) {
                            $preciorealString = explode("+ IVA",$preciorealProducto);
                            $preciorealStringFinal = str_replace(array("$"), '', $preciorealString[0]);
                            $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);
                        }else{
                            $precioString = explode("+ IVA",$preciorealProducto);
                            $preciorealStringFinal = str_replace(array("$"), '', $precioString[0]);
                            $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);

                        }
                    }
                                        
                    if ($precioRealPlano > $precioActualPlano) {
                        $descuentoProducto = (float)$precioRealPlano - (float)$precioActualPlano;
                    }else{
                        $descuentoProducto = 0;
                    }
                    
                    $igvProducto = stristr($preciorealProducto,'IVA') ? true : false;
                    $ofertaProducto = $node->filter("[class='onsale']")->text('Sin Oferta');

                    $fecid = $this->validarDataPorFecha(13);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid           = $pagId;
                    $dtpdatospaginas->fecid           = $fecid;
                    $dtpdatospaginas->tpmid           = $tpmid;
                    $dtpdatospaginas->dtpnombre       = $nombreProducto;
                    $dtpdatospaginas->dtpurl          = $urlProducto;
                    $dtpdatospaginas->dtpimagen       = $imagenProducto;
                    $dtpdatospaginas->dtpprecioactual = $precioActualPlano;
                    $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                    $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                    $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                    $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                    $dtpdatospaginas->dtpsigv         = $igvProducto;
                    $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                    $dtpdatospaginas->dtppalabraclave = $palabraclave;
                    if($dtpdatospaginas->save()){
                        $this->obtenerProId($nombreProducto, null, $pagId, $dtpdatospaginas->id, $imagenProducto);
                    } 
                });
            }
        }
    }

    public function MetObtenerCentralMayorista()
    {
        $pagId       = 14;
        $tpmid       = 1;

        $url = 'https://deadpool.instaleap.io/api/v2';
        $queryCategorias = array('operationName'=>'getStore','variables'=>['clientId'=>'CENTRAL_MAYORISTA'],'query'=>'query getStore($storeId: ID, $clientId: String) {  getStore(storeId: $storeId, clientId: $clientId) {    id    name    categories {      id      image      slug      name      redirectTo      isAvailableInHome      __typename    }    banners {      id      title      desktopImage      mobileImage      targetCategory      targetUrl {        url        type        __typename      }      __typename    }    __typename  }}');
        $queryCategoriasJson = json_encode($queryCategorias);
        $datosCategorias = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($queryCategoriasJson)
                            ->send();
        $store = $datosCategorias->body->data->getStore->id;
        $categorias = array(
            (object)
            [ 
                'id'           => '63489',
                'categoria'    => 'Jabones',
                'palabraclave' => 'Jabón'
            ],
            (object)
            [
                'id'           => '63531',
                'categoria'    => 'Toallas de Papel',
                'palabraclave' => 'Toalla'
            ],
            (object)
            [
                'id'           => '63530',
                'categoria'    => 'Servilletas',
                'palabraclave' => 'Servilleta'
            ],
            (object)
            [
                'id'           => '63529',
                'categoria'    => 'Papel Higiénico',
                'palabraclave' => 'Papel Higiénico'
            ],
            (object)
            [
                'id'           => '63545',
                'categoria'    => 'Pañales Bebe',
                'palabraclave' => 'Pañal'
            ],
            (object)
            [
                'id'           => '63494',
                'categoria'    => 'Cuidado Adulto Mayor',
                'productos'    => 'Pañales Adulto',
                'palabraclave' => 'Pañal'
            ],
            (object)
            [
                'id'           => '63534',
                'categoria'    => 'Limpiadores Hogar',
                'productos'    => 'Desengrasantes/Limpiavidrios/Lavalozas',
                'palabraclave' => 'Lavalozas, Limpiavidrios, Desengrasante'
            ],
            (object)
            [
                'id'           => '63533',
                'categoria'    => 'Accesorios Aseo',
                'productos'    => 'Wipes',
                'palabraclave' => 'Wipes'
            ],
        );
        if($this->validarDataPorFecha(14, true)){
            foreach ($categorias as $categoria){
                $id = $categoria->id;
                $tituloCategoria = $categoria->categoria;
                $palabraclave = $categoria->palabraclave;

                $queryProductosObtenerPaginas = array('variables'=> ['categoryId'=> $id,'onlyThisCategory'=>false,'pagination'=>['pageSize'=>30,'currentPage'=>1],'storeId'=>$store],'query'=>'query ($pagination: paginationInput, $search: SearchInput, $storeId: ID!, $categoryId: ID, $onlyThisCategory: Boolean, $filter: ProductsFilterInput, $orderBy: productsSortInput) {  getProducts(pagination: $pagination, search: $search, storeId: $storeId, categoryId: $categoryId, onlyThisCategory: $onlyThisCategory, filter: $filter, orderBy: $orderBy) {    redirectTo    products {      id      description      name      photosUrls      sku      unit      price      specialPrice      promotion {        description        type        isActive        conditions        __typename      }      stock      nutritionalDetails      clickMultiplier      subQty      subUnit      maxQty      minQty      specialMaxQty      ean      boost      showSubUnit      isActive      slug      categories {        id        name        __typename      }      __typename    }    paginator {      pages      page      __typename    }    __typename  }}');
                $queryProductosObtenerPaginasJson = json_encode($queryProductosObtenerPaginas);
                $datosProductosObtenerCantidadPaginas = \Httpful\Request::post($url)
                                        ->sendsJson()
                                        ->body($queryProductosObtenerPaginasJson)
                                        ->send();
                $paginas =$datosProductosObtenerCantidadPaginas->body->data->getProducts->paginator->pages;

                for($i=1; $i<=$paginas;$i++)
                {
                    $queryProductos = array('variables'=> ['categoryId'=> $id,'onlyThisCategory'=>false,'pagination'=>['pageSize'=>30,'currentPage'=>$i],'storeId'=>$store],'query'=>'query ($pagination: paginationInput, $search: SearchInput, $storeId: ID!, $categoryId: ID, $onlyThisCategory: Boolean, $filter: ProductsFilterInput, $orderBy: productsSortInput) {  getProducts(pagination: $pagination, search: $search, storeId: $storeId, categoryId: $categoryId, onlyThisCategory: $onlyThisCategory, filter: $filter, orderBy: $orderBy) {    redirectTo    products {      id      description      name      photosUrls      sku      unit      price      specialPrice      promotion {        description        type        isActive        conditions        __typename      }      stock      nutritionalDetails      clickMultiplier      subQty      subUnit      maxQty      minQty      specialMaxQty      ean      boost      showSubUnit      isActive      slug      categories {        id        name        __typename      }      __typename    }    paginator {      pages      page      __typename    }    __typename  }}');
                    $queryProductosJson = json_encode($queryProductos);
                    $datosProductos = \Httpful\Request::post($url)
                                            ->sendsJson()
                                            ->body($queryProductosJson)
                                            ->send();
                    $productos =$datosProductos->body->data->getProducts->products;
                    $pagina = $i;
                    foreach ($productos as $producto) 
                    {
                        $fecid = $this->validarDataPorFecha(14);
                        $dtpunidadmedida = $this->obtenerUnidadMedida($producto->name);
                        $precioRealPlano = $this->obtenerPrecioPlano($producto->price);
                        $precioActualPlano = $this->obtenerPrecioPlano($producto->specialPrice);
                        if ($precioActualPlano == 0) {
                            $precioActual = $precioRealPlano;
                        }else{
                            $precioActual = $precioActualPlano;
                        }
                        if ($precioRealPlano > $precioActual) {
                            $descuentoProducto = $precioRealPlano - $precioActual;
                        }else{
                            $descuentoProducto = 0;
                        }
                        
                        if ($descuentoProducto > 0) {
                            $ofertaProducto = "¡Con Oferta!";
                        }else{
                            $ofertaProducto = "¡Sin Oferta!";
                        }
                        $urlProducto = "https://www.centralmayorista.cl/p/$producto->slug";

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid           = $pagId;
                        $dtpdatospaginas->fecid           = $fecid;
                        $dtpdatospaginas->tpmid           = $tpmid;
                        $dtpdatospaginas->dtpnombre       = $producto->name;
                        $dtpdatospaginas->dtppagina       = $pagina;
                        $dtpdatospaginas->dtpimagen       = $producto->photosUrls[0];
                        $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                        $dtpdatospaginas->dtpprecioactual = $precioActual;
                        $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                        $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                        $dtpdatospaginas->dtpcategoria    = $tituloCategoria;
                        $dtpdatospaginas->dtpsku          = $producto->sku;
                        $dtpdatospaginas->dtpstock        = $producto->stock;
                        $dtpdatospaginas->dtpdesclarga    = $producto->description;
                        $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida;
                        $dtpdatospaginas->dtpean          = $producto->ean[0]; 
                        $dtpdatospaginas->dtpurl          = $urlProducto;
                        $dtpdatospaginas->dtppalabraclave = $palabraclave;
                        if($dtpdatospaginas->save()){
                            $this->obtenerProId($producto->name, $producto->sku, $pagId, $dtpdatospaginas->id, $producto->photosUrls[0]);
                        } 
                    }
                }
            }
        }
    }

    public function MetObtenerCuponatic()
    {
        $pagId = 15;
        $tpmid = 1;
        $categorias = array('productos','servicios','gastronomia');
        foreach ($categorias as $categoria) {
            $urlCategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/menu/seccion/$categoria?ciudad=Santiago";
            $datosCategoria = \Httpful\Request::get($urlCategoria)
                                    ->sendsJson()
                                    ->send();
            $subcategorias = array(
                (object)
                [ 
                    'slug'         => 'aseo-y-limpieza',
                    'categoria'    => 'Aseo y Limpieza',
                    'producto'     => 'Papel Higienico / Dispensador / Alcohol Gel / Lavalozas / Limpiavidrio / Desengrasante / Dispensador Jabon',
                    'palabraclave' => 'Papel Higiénico, Dispensador, Alcohol Gel, Lavalozas, Limpiavidrios, Desengrasante'
                ], 
                (object)
                [
                    'slug'         => 'cuidado-de-la-piel',
                    'categoria'    => 'Cuidado de la Piel',
                    'producto'     => 'Jabon',
                    'palabraclave' => 'Jabón'
                ],
                (object)
                [
                    'slug'         => 'otros-cocina',
                    'categoria'    => 'Otros Cocina',
                    'producto'     => 'Dispensador Toalla / Servilleta / Dispensador Agua Purificada',
                    'palabraclave' => 'Servilleta, Dispensador'
                ],
                (object)
                [
                    'slug'         => 'utensilios',
                    'categoria'    => 'Utensilios',
                    'producto'     => 'Dispensador Agua',
                    'palabraclave' => 'Dispensador'
                ],
                (object)
                [
                    'slug'         => 'higiene',
                    'categoria'    => 'Higiene',
                    'producto'     => 'Servilleta',
                    'palabraclave' => 'Servilleta'
                ],
                (object)
                [
                    'slug'         => 'para-el-bano',
                    'categoria'    => 'Para el baño',
                    'producto'     => 'Dispensador Automatico',
                    'palabraclave' => 'Dispensador'
                ],

            );
            if($this->validarDataPorFecha(15, true)){
                foreach ($subcategorias as $subcategoria) {
                    $slug = $subcategoria->slug;
                    $palabraclave = $subcategoria->palabraclave;
                    $categoria = $subcategoria->categoria;
                    $encontroPagina = true;
                    $numeroPaginas = 1;
                    while($encontroPagina == true)
                    {
                        $urlSubcategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/descuentos/menu/$slug?ciudad=Santiago&v=14&page=$numeroPaginas";
                        $datosSubcategoria = \Httpful\Request::get($urlSubcategoria)
                                                ->sendsJson()
                                                ->send();

                        $productosSubcategorias = $datosSubcategoria->body;
                        if(sizeof($productosSubcategorias)>0){
                            foreach ($productosSubcategorias as $productosSubcategoria) {

                                $fecid = $this->validarDataPorFecha(15);
                           
                                $preciorealStringFinal = str_replace(array("$"), '', $productosSubcategoria->valor_original);
                                $precioRealPlano = $this->obtenerPrecioPlano($preciorealStringFinal);
                                $precioactualStringFinal = str_replace(array("$"), '', $productosSubcategoria->valor_oferta);
                                $precioActualPlano = $this->obtenerPrecioPlano($precioactualStringFinal);
                                if ($precioRealPlano == null) {
                                    $precioRealPlano = $precioActualPlano;
                                }
                                if ($precioActualPlano < $precioRealPlano) {
                                    $descuentoProducto = (float)$precioRealPlano - (float)$precioActualPlano;
                                }else{
                                    $descuentoProducto = 0;
                                }
                                if ($descuentoProducto > 0) {
                                    $ofertaProducto = "¡Con Oferta!";
                                }else{
                                    $ofertaProducto = "¡Sin Oferta!";
                                }
                                $dtpunidadmedida = $this->obtenerUnidadMedida($productosSubcategoria->titulo);
                                
                                $dtpdatospaginas = new dtpdatospaginas();
                                $dtpdatospaginas->pagid           = $pagId;
                                $dtpdatospaginas->fecid           = $fecid;
                                $dtpdatospaginas->tpmid           = $tpmid;
                                $dtpdatospaginas->dtpnombre       = $productosSubcategoria->titulo;
                                $dtpdatospaginas->dtppagina       = $numeroPaginas;
                                $dtpdatospaginas->dtpimagen       = $productosSubcategoria->imagen;
                                $dtpdatospaginas->dtpprecioactual = $precioActualPlano;
                                $dtpdatospaginas->dtpprecioreal   = $precioRealPlano;
                                $dtpdatospaginas->dtpdescuento    = $descuentoProducto;
                                $dtpdatospaginas->dtpmecanica     = $ofertaProducto;
                                $dtpdatospaginas->dtpcategoria    = $categoria;
                                $dtpdatospaginas->dtpurl          = $productosSubcategoria->url_desktop;
                                $dtpdatospaginas->dtpstock        = $productosSubcategoria->estado_venta;
                                $dtpdatospaginas->dtpmarca        = $productosSubcategoria->marcas;
                                $dtpdatospaginas->dtpunidadmedida = $dtpunidadmedida; 
                                $dtpdatospaginas->dtppalabraclave = $palabraclave;
                                if($dtpdatospaginas->save()){
                                    $this->obtenerProId($productosSubcategoria->titulo, null, $pagId, $dtpdatospaginas->id, $productosSubcategoria->imagen);
                                } 
                            }
                            $numeroPaginas = $numeroPaginas + 1;
                        }else {
                            $encontroPagina = false;
                            break;
                        }
                    }                
                }
            }
        }
    }
}
