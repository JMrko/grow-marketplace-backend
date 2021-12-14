<?php

namespace App\Http\Controllers\Metodos\ETL;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\fecfechas;
use DateTime;
use Goutte\Client;

class MetEtlObtenerDatosPaginasController extends Controller
{
       public function validarDataPorFecha($pagid=0, $eliminarData=false)
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
                dtpdatospaginas::where('pagid',$pagid)
                                ->where('fecid',$fecid)
                                ->delete();
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
    
    public function MetObtenerArcalauquen(Client $client)
    {
        $pagId = 1;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/15-papel-higienico?page=1',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/16-toallas?page=1',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/8-detergentes-desinfectantes-y-jabones?page=1',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/19-servilletas?page=1',
                'categoria'             => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/20-panuelos-desechables?page=1',
                'categoria'             => 'Pañuelo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/17-sabanillas?page=1',
                'categoria'             => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/18-panos-de-limpieza?page=1',
                'categoria'             => 'Paños'
            ]
            );
        if($this->validarDataPorFecha(1, true)){
            foreach ($categoriasLink as $categoriaLink) { 
                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
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

                    $crawler->filter(".js-product-miniature-wrapper")->each(function($node) use($pagina, $tituloCategoria, $pagId){
                        $imagenProducto = $node->filter(".product-thumbnail > img")->attr('data-src');
                        $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                        $precioProducto = $node->filter("[class='product-price-and-shipping']")->text();
                        $precioString = explode("$",$precioProducto);
                        $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                        $descProducto = $node->filter(".product-description-short")->text();
                        $stockProducto = $node->filter("[class='product-availability d-block']")->text();
                        $skuProducto = $node->filter("[class='product-reference text-muted']")->text();

                        $fecid = $this->validarDataPorFecha(1);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->fecid        = $fecid;
                        $dtpdatospaginas->pagid        = $pagId;
                        $dtpdatospaginas->dtpnombre    = $nombreProducto;
                        $dtpdatospaginas->dtpprecio    = $precioString[0];
                        $dtpdatospaginas->dtpurl       = $urlProducto;
                        $dtpdatospaginas->dtpimagen    = $imagenProducto;
                        $dtpdatospaginas->dtpdesclarga = $descProducto;
                        $dtpdatospaginas->dtppagina    = $pagina;
                        $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                        $dtpdatospaginas->dtpstock     = $stockProducto;
                        $dtpdatospaginas->dtpsku       = $skuProducto;
                        $dtpdatospaginas->save();
                    });
                }
            }
        }
    }

    public function MetObtenerTork(Client $client)
    {
        $pagId = 2;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/papel-higienico',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/toalla-en-rollo',
                'categoria'             => 'Toalla en rollo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/toalla-interfoliada',
                'categoria'             => 'Toalla Interfoliada'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/jabon',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/insumos/servilletas',
                'categoria'             => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://torkalpormayor.cl/collections/sabanilla-medica',
                'categoria'             => 'Sabanilla Medica'
            ]
        );
        if($this->validarDataPorFecha(2, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $categoriaLink->categoria;
                $crawler->filter(".product-grid-item")->each(function($node) use($pagId, $tituloCategoria){
                    $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
                    $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']")->text();
                    $precioProducto = $node->filter("[class='money']")->text();
                    $precioString = explode("$",$precioProducto);
                    $urlProducto = $node->filter(".lazy-image")->attr('href');
                    
                    $fecid = $this->validarDataPorFecha(2);
                    
                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreProducto;
                    $dtpdatospaginas->dtpprecio    = $precioString[1];
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->dtpurl       = $urlProducto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;   
                    $dtpdatospaginas->save();
                });
            }
        } 
    }

    public function MetObtenerDipisa(Client $client)
    {
        $pagId = 3;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/papel-higienico/',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/toallas-de-papel/',
                'categoria'             => 'Toallas de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/dispensador/',
                'categoria'             => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dipisa.cl/tipo_tissues/sabanilla/',
                'categoria'             => 'Sabanilla'
            ],
        );
        if($this->validarDataPorFecha(3, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter("[class='col-md-12 text-center']")->first()->text();

                $crawler->filter("[class='col-md-4 mb50']")->each(function($node) use($tituloCategoria, $pagId){
                    $imagenProducto = $node->filter(".box-contenido > img")->attr('src');
                    $nombrePrecioProducto = $node->filter("h5")->text();
                    $nombreProducto = explode ("Un.", $nombrePrecioProducto);
                    $precioProducto = explode("Precio:", $nombrePrecioProducto);
                    $precioString = explode("$",$precioProducto[1]);
                    $precioStringFinal = explode("+", $precioString[1]);
                    $marcaProducto = $node->filter(".box-contenido > h4")->text();
                    $skuProducto = $node->filter("p > span")->text();
                    $nombreCompleto = $marcaProducto .' '. $nombreProducto[0];

                    $fecid = $this->validarDataPorFecha(3);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreCompleto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->dtpmarca     = $marcaProducto;
                    $dtpdatospaginas->dtpsku       = $skuProducto;
                    $dtpdatospaginas->dtpprecio    = $precioStringFinal[0];
                    $dtpdatospaginas->save();
                });
            }
        }
    }

    public function MetObtenerAvalco(Client $client)
    {
        $pagId = 4;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/167-papel-higienico?page=1',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/165-papel-higienico-jumbo?page=1',
                'categoria'             => 'Papel Higiénico Jumbo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/166-toallas-interfoliadas?page=1',
                'categoria'             => 'Toallas Interfoliadas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/61-papeles-higienicos-y-toallas-de-papel?page=1',
                'categoria'             => 'Papel Higienico y Toallas de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/73-jabones?page=1',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/126-servilletas-de-papel?page=1',
                'categoria'             => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/22-dispensadores-de-jabon?page=1',
                'categoria'             => 'Dispensador de Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/23-dispensadores-de-papel?page=1',
                'categoria'             => 'Dispensador de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/139-alcohol-desnaturalizado?page=1',
                'categoria'             => 'Jabon Desnaturalizado'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/131-alcohol-etilico?page=1',
                'categoria'             => 'Alcochol Etilico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/129-alcohol-gel?page=1',
                'categoria'             => 'Alcohol Gel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/130-alcohol-isopropilico?page=1',
                'categoria'             => 'Alcohol Isopropilico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.avalco.cl/40-desengrasantes?page=1',
                'categoria'             => 'Desengrasante'
            ],
        );
        if($this->validarDataPorFecha(4, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
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
                    
                    $crawler->filter("[class='product-miniature product-style js-product-miniature']")->each(function($node) use($tituloCategoria, $pagina, $pagId){
                        $imagenProducto = $node->filter(".product-cover-link > img")->attr('src');
                        $nombreProducto = $node->filter(".product-name")->text();
                        $precioProducto = $node->filter("[class='price product-price']")->text();
                        $precioString = explode("$",$precioProducto);
                        $urlProducto = $node->filter(".product-name > a")->attr('href');
                        $stringSkuProducto = $node->filter(".second-block > h4")->text();
                        $skuProducto = explode ("Ref:", $stringSkuProducto);
                        $stockProducto = $node->filter(".available")->text('-');
                        $descProducto = $node->filter(".product-description-short")->text();

                        $fecid = $this->validarDataPorFecha(4);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid        = $pagId;
                        $dtpdatospaginas->fecid        = $fecid;
                        $dtpdatospaginas->dtpnombre    = $nombreProducto;
                        $dtpdatospaginas->dtpimagen    = $imagenProducto;
                        $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                        $dtpdatospaginas->dtpurl       = $urlProducto;
                        $dtpdatospaginas->dtpprecio    = $precioString[0];
                        $dtpdatospaginas->dtppagina    = $pagina;
                        $dtpdatospaginas->dtpstock     = $stockProducto;
                        $dtpdatospaginas->dtpsku       = $skuProducto[1];
                        $dtpdatospaginas->dtpdesclarga = $descProducto;
                        $dtpdatospaginas->save();
                    });
                }
            }

        }
    }

    public function MetObtenerDilen(Client $client)
    {
        $pagId = 5;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/toalla-de-papel/',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/jabones/',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-bajo-metraje/',
                'categoria'             => 'Dispensador de Papel Higienico de Bajo Metraje'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-bajo-metraje-interfoliado/',
                'categoria'             => 'Dispensador de Papel Higienico de Bajo Metraje Interfoliado'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-alto-metraje/',
                'categoria'             => 'Dispensador de Papel Higienico de Alto Metraje'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/servilleta/dispensador-servilleta-express/',
                'categoria'             => 'Servilleta Express'
            ],(object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/servilleta/dispensador-servilleta-mesa/',
                'categoria'             => 'Servilleta Mesa'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/sabanillas/dispensador-sabanillas/',
                'categoria'             => 'Dispensador de Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/accesorios-de-bano/cobertor-w-c/dispensador-cobertor-w-c/',
                'categoria'             => 'Dispensador Cobertor W.C'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/jabones/jabon-rellenable/dispensador-jabon-rellenable/',
                'categoria'             => 'Dispensador de Jabon Rellenable'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/jabones/jabon-multiflex/dispensador-jabon-multiflex/',
                'categoria'             => 'Dispensador de Jabon Multiflex'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/panos-de-limpieza/dispensador-panos-de-limpieza/',
                'categoria'             => 'Dispensador de Panos de Limpieza'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/servilleta/',
                'categoria'             => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/sabanillas/',
                'categoria'             => 'Sabanilla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/panal-para-adultos/',
                'categoria'             => 'Panal para adultos'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/panos-de-limpieza/',
                'categoria'             => 'Panos de Limpieza'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/higiene-y-cuidados/alcohol-gel/',
                'categoria'             => 'Alcohol Gel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/lavalozas/',
                'categoria'             => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/limpiavidrios/',
                'categoria'             => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/desengrasante/',
                'categoria'             => 'Desengrasantes'
            ],                    
        );
        if($this->validarDataPorFecha(5, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter(".title")->text();

                $crawler->filter(".isotope-item")->each(function($node) use($tituloCategoria, $pagId){
                    $imagenProducto = $node->filter("[class='scale-with-grid wp-post-image']")->attr('src');
                    $nombreProducto = $node->filter(".desc > h4")->text();
                    $urlProducto = $node->filter(".image_wrapper > a")->attr('href');
                    $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
                    $precioString = explode("$",$precioProducto);

                    $fecid = $this->validarDataPorFecha(5);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreProducto;
                    $dtpdatospaginas->dtpurl       = $urlProducto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;
                    $dtpdatospaginas->dtpprecio    = $precioString[1];
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->save();
                });
            }
        }
    }

    public function MetObtenerSodimac(Client $client)
    {
        $pagId = 6;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=papel%2520higienico',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=toalla',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=servilleta&currentpage=1',
                'categoria'             => 'Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850181?currentpage=1&=&f.product.attribute.Tipo=dispensadores%2520de%2520jabon',
                'categoria'             => 'Dispensador de Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=dispensador%20de%20servilleta?currentpage=1',
                'categoria'             => 'Dispensador de Servilleta'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/scat963514/Limpieza?Ntt=dispensadores&sTerm=dispensadores&sType=category&sScenario=BTP_CAT_dispensadores&currentpage=1&f.product.attribute.Tipo=dispensador%2520papel%2520higienico',
                'categoria'             => 'Dispensador de Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/scat963514/Limpieza?Ntt=jabones%20alcohol&sTerm=jabones&sType=category&sScenario=BTP_CAT_jabones%20alcohol&currentpage=1&f.product.attribute.Tipo=jabon',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat9230001/Insumos-Medicos?currentpage=1',
                'categoria'             => 'Sabanillas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat11540001/Proteccion-Sanitaria?currentpage=1&=&f.product.attribute.Tipo=alcohol%3A%3Aalcohol%2520gel',
                'categoria'             => 'Alcohol Gel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850292/Limpiadores-de-cocina?currentpage=1&=&f.product.attribute.Tipo=lavalozas',
                'categoria'             => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850294/Limpiadores-Especificos?currentpage=1&=&f.product.attribute.Tipo=limpiavidrios',
                'categoria'             => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=desengrasantes&currentpage=1&f.product.attribute.Tipo=desengrasante',
                'categoria'             => 'Desengrasantes'
            ],
        );
        if($this->validarDataPorFecha(6, true)){
            foreach ($categoriasLink as $categoriaLink) {
                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter("[class='jsx-4278284191 page-item page-index ']")->last()->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i)
                {
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

                    $crawler->filter("[class='jsx-411745769 product ie11-product-container']")->each(function($node) use($tituloCategoria, $pagina, $pagId){
                        $imagenProducto = $node->filter("[class='image-contain ie11-image-contain  __lazy']")->attr('data-src');
                        $nombreProducto = $node->filter("[class='jsx-411745769 product-title']")->text();
                        $marcaProducto = $node->filter("[class='jsx-411745769 product-brand']")->text();
                        $urlProducto = $node->filter("[class='jsx-4282314783 link link-primary ']")->attr('href');
                        $precioProducto = $node->filter("[class='jsx-4135487716']")->text();
                        $precioString = explode("$",$precioProducto);

                        $fecid = $this->validarDataPorFecha(6);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid        = $pagId;
                        $dtpdatospaginas->fecid        = $fecid;
                        $dtpdatospaginas->dtpnombre    = $nombreProducto;
                        $dtpdatospaginas->dtpurl       = $urlProducto;
                        $dtpdatospaginas->dtpimagen    = $imagenProducto;
                        $dtpdatospaginas->dtpprecio    = $precioString[1];
                        $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                        $dtpdatospaginas->dtpmarca     = $marcaProducto;
                        $dtpdatospaginas->dtppagina    = $pagina;
                        $dtpdatospaginas->save();
                    });
                }
            }
        }
    }

    public function MetObtenerDpronto(Client $client)
    {
        $pagId = 7;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/dispensadores-de-jabon/',
                'categoria'             => 'Dispensador de Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/dispensadores-de-jabon-papel-hig-toalla/',
                'categoria'             => 'Dispensador de Jabon Papel Hig. Toalla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/jabones/',
                'categoria'             => 'Jabones'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/papeles-higienicos/',
                'categoria'             => 'Papeles Higienicos'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/toallas-de-papel-y-servilletas/',
                'categoria'             => 'Toallas de Papel y Servilletas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/lavalozas-y-desengrasantes/',
                'categoria'             => 'Lavalozas y Desengrasantes'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/limpiavidrios/',
                'categoria'             => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.dpronto.cl/product-category/productos-de-limpieza/desinfectantes-sanitizantes-enzimaticos/',
                'categoria'             => 'Desinfectantes Sanitizantes Enzimaticos'
            ],
        );

        if($this->validarDataPorFecha(7, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $categoriaLink->categoria;
                
                $crawler->filter("[class='product-small box ']")->each(function($node) use($tituloCategoria, $pagId){
                    $imagenProducto = $node->filter(".image-zoom > a > img")->attr('data-src');
                    $nombreProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->text();
                    $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
                    $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
                    $precioString = explode("$",$precioProducto);

                    $fecid = $this->validarDataPorFecha(7);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreProducto;
                    $dtpdatospaginas->dtpurl       = $urlProducto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;
                    $dtpdatospaginas->dtpprecio    = $precioString[1];
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->save();   
                });
            }
        }
    }

    public function MetObtenerComcer(Client $client)
    {
        $pagId = 8;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/papeles-higienicos-formato-hogar-y-jumbo/',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/toalla-de-papel/',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/sabanillas/',
                'categoria'             => 'Sabanillas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/papeles/servilletas/',
                'categoria'             => 'Servilletas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/dispensadores/',
                'categoria'             => 'Dispensadores'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/jabones/',
                'categoria'             => 'Jabon Gel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/panos/',
                'categoria'             => 'Panos'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/proteccion-covid-19/jabon-y-alcohol-gel/',
                'categoria'             => 'Jabon y Alcohol Gel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.comcer.cl/store/categoria-producto/detergentes/lavalozas/',
                'categoria'             => 'Lavalozas y Desengrasantes'
            ],
        );
        if($this->validarDataPorFecha(8, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter("[class='woocommerce-products-header__title page-title']")->text();

                $crawler->filter(".products > li")->each(function($node) use($tituloCategoria, $pagId){
                    $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
                    $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']")->text();
                    $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
                    $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
                    
                    $fecid = $this->validarDataPorFecha(8);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreProducto;
                    $dtpdatospaginas->dtpurl       = $urlProducto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;
                    $dtpdatospaginas->dtpprecio    = $precioProducto;
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->save();   
                });
            }
        }
    }

    public function MetObtenerOfimaster(Client $client)
    {
        $pagId = 9;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/papel-tissue/papel-higienico?page=1',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/papel-tissue/toalla-de-papel?page=1',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/quimicos-de-limpieza/jabones?page=1',
                'categoria'             => 'Jabones'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-aromas?page=1',
                'categoria'             => 'Dispensador de Aromas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-jabon?page=1',
                'categoria'             => 'Dispensador de Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-papel-higiienico?page=1',
                'categoria'             => 'Dispensador de Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/dispensadores/de-toalla-de-papel?page=1',
                'categoria'             => 'Dispensador de Toalla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/papel-tissue/servilletas?page=1',
                'categoria'             => 'Servilletas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=sabanilla&page=1',
                'categoria'             => 'Sabanillas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=pa%C3%B1o&page=1',
                'categoria'             => 'Paños'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=pa%C3%B1uelo%7D&page=1',
                'categoria'             => 'Pañuelos'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=alcohol&page=1',
                'categoria'             => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=lavaloza&page=1',
                'categoria'             => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=limpiavidrio&page=1',
                'categoria'             => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.ofimaster.cl/search?q=desengrasante&page=1',
                'categoria'             => 'Desengrasantes'
            ],

        );

        if($this->validarDataPorFecha(9, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter('.count > span')->last()->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i){

                    $nuevaURLPage = explode('page=', $paginaURLPages);
                    $stringSeleccionado = $nuevaURLPage[0];
                    $paginaURL = "$stringSeleccionado"."page=$i";

                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $categoriaLink->categoria;
                    $pagina = $i;
                    
                    $crawler->filter("[class='product-block']")->each(function($node) use($tituloCategoria, $pagina, $pagId){
                        $imagenProducto = $node->filter("[class='img-fluid']")->attr('src');
                        $nombreProducto = $node->filter("[class='brand-name trsn']")->text();
                        $urlProducto = $node->filter(".product-block > a")->attr('href');
                        $precioProducto = $node->filter("[class='block-price']")->text();
                        $marcaProducto = $node->filter("[class='brand']")->text('-');

                        $fecid = $this->validarDataPorFecha(9);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid        = $pagId;
                        $dtpdatospaginas->fecid        = $fecid;
                        $dtpdatospaginas->dtpnombre    = $nombreProducto;
                        $dtpdatospaginas->dtpurl       = $urlProducto;
                        $dtpdatospaginas->dtpimagen    = $imagenProducto;
                        $dtpdatospaginas->dtpprecio    = $precioProducto;
                        $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                        $dtpdatospaginas->dtppagina    = $pagina;
                        $dtpdatospaginas->dtpmarca     = $marcaProducto;
                        $dtpdatospaginas->save();   
                    });
                }
            }
        }
    }

    public function MetObtenerDaos(Client $client)
    {
        $pagId = 10;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/15-papel-higienico',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/17-toalla-de-papel',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/21-lavalozas',
                'categoria'             => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/70-jabon-liquido',
                'categoria'             => 'Jabon Liquido'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/71-jabon-en-barra',
                'categoria'             => 'Jabon Barra'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/22-antigrasa',
                'categoria'             => 'Desengrasante'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/27-limpiadores',
                'categoria'             => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://daos.cl/home/101-alcohol-gel',
                'categoria'             => 'Alcohol Gel'
            ],
        );
        if($this->validarDataPorFecha(10, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter(".page-list > li")->eq(4)->text('1');
                
                for($i=1; $i<=$numeroPaginas; ++$i){

                    $paginaURL = "$paginaURLPages?page=$i";
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $crawler->filter(".h2")->text();
                    $pagina = $i;
                    
                    $crawler->filter("[class='thumbnail-container']")->each(function($node) use($tituloCategoria, $pagina, $pagId){
                        $imagenProducto = $node->filter("[class='ttproduct-img1']")->attr('src');
                        $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                        $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                        $precioProducto = $node->filter("[class='price']")->text();
                        
                        $fecid = $this->validarDataPorFecha(10);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid        = $pagId;
                        $dtpdatospaginas->fecid        = $fecid;
                        $dtpdatospaginas->dtpnombre    = $nombreProducto;
                        $dtpdatospaginas->dtpurl       = $urlProducto;
                        $dtpdatospaginas->dtpimagen    = $imagenProducto;
                        $dtpdatospaginas->dtpprecio    = $precioProducto;
                        $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                        $dtpdatospaginas->dtppagina    = $pagina;
                        $dtpdatospaginas->save();
                    });
                }
            }
        }
    }

    public function MetObtenerProvit(Client $client)
    {
        $pagId = 11;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/10/papel-higienico',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/12/tollas-en-rollo',
                'categoria'             => 'Toallas en Rollo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/13/toallas-interfoliadas',
                'categoria'             => 'Toallas Interfoliadas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/14/sabanillas',
                'categoria'             => 'Sabanillas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/1/jabon',
                'categoria'             => 'Jabones'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/lineas/1/dispensadores',
                'categoria'             => 'Dispensadores'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/11/servilletas',
                'categoria'             => 'Servilletas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/categorias/3/panos',
                'categoria'             => 'Paños'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/alcohol',
                'categoria'             => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/lavaloza',
                'categoria'             => 'Lavalozas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/limpiavidrio',
                'categoria'             => 'Limpiavidrios'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://provit.cl/busquedas/desengrasante',
                'categoria'             => 'Desengrasantes'
            ],
        );
        if($this->validarDataPorFecha(11, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURLPages = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURLPages);
                $numeroPaginas = $crawler->filter(".paginate")->last()->text('1');

                for($i=1; $i<=$numeroPaginas; ++$i){
                    $paginaURL = "$paginaURLPages/9999/0/0/9999/0/9/pagina-$i";
                    $crawler = $client->request('GET', $paginaURL);
                    $tituloCategoria = $categoriaLink->categoria;
                    $pagina = $i;
                    
                    $crawler->filter("[class='grilla']")->each(function($node) use($tituloCategoria, $pagina, $pagId){
                        $imagenProducto = $node->filter(".imgGrilla > img")->attr('src');
                        $nombreProducto = $node->filter("[class='nombreGrilla']")->text();
                        $urlProducto = $node->filter("[class='nombreGrilla']")->attr('href');
                        $precioProducto = $node->filter("[class='conDescuento']")->text();
                        
                        $fecid = $this->validarDataPorFecha(11);

                        $dtpdatospaginas = new dtpdatospaginas();
                        $dtpdatospaginas->pagid        = $pagId;
                        $dtpdatospaginas->fecid        = $fecid;
                        $dtpdatospaginas->dtpnombre    = $nombreProducto;
                        $dtpdatospaginas->dtpurl       = $urlProducto;
                        $dtpdatospaginas->dtpimagen    = $imagenProducto;
                        $dtpdatospaginas->dtpprecio    = $precioProducto;
                        $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                        $dtpdatospaginas->dtppagina    = $pagina;
                        $dtpdatospaginas->save();
                    });
                }
            }
        }
    }

    public function MetObtenerLimpiamas(Client $client)
    {
        $pagId = 12;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/papel-higienico',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/toalla',
                'categoria'             => 'Toalla de Papel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/jabon',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/dispensador',
                'categoria'             => 'Dispensador'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/servilleta',
                'categoria'             => 'Servilletas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/sabanilla',
                'categoria'             => 'Sabanillas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/pañal',
                'categoria'             => 'Pañales'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://limpiamas.mercadoshops.cl/alcohol',
                'categoria'             => 'Alcohol'
            ],

        );
        if($this->validarDataPorFecha(12, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter(".ui-search-breadcrumb__title")->text();
                
                $crawler->filter("[class='ui-search-result__wrapper']")->each(function($node) use($tituloCategoria, $pagId){
                    $imagenProducto = $node->filter(".slick-slide > img")->attr('src');
                    $nombreProducto = $node->filter("[class='ui-search-item__title']")->text();
                    $urlProducto = $node->filter("[class='ui-search-item__group__element ui-search-link']")->attr('href');
                    $precioProducto = $node->filter("[class='price-tag-amount']")->text();

                    $fecid = $this->validarDataPorFecha(12);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreProducto;
                    $dtpdatospaginas->dtpurl       = $urlProducto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;
                    $dtpdatospaginas->dtpprecio    = $precioProducto;
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->save();    
                });
            }
        }
    }

    public function MetObtenerHygiene(Client $client){
        $pagId = 13;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/higenicos/',
                'categoria'             => 'Papel Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/dobladas/',
                'categoria'             => 'Toalla Doblada'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/toallas-rollo/',
                'categoria'             => 'Toalla Rollo'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/wipe/',
                'categoria'             => 'Toalla Wipe'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/jabones/',
                'categoria'             => 'Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/otros-papeles/sabanillas-medicas/',
                'categoria'             => 'Sabanillas Medicas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/desengrasantes/',
                'categoria'             => 'Desengrasantes'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/accesorios-superficies/panos/',
                'categoria'             => 'Paños'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/otros-papeles/panuelos-faciales/',
                'categoria'             => 'Pañuelos Faciales'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/servilletas-gourmet/',
                'categoria'             => 'Servilleta Gourmet'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-mesa/',
                'categoria'             => 'Servilleta Mesa'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-interfoliadas/',
                'categoria'             => 'Servilleta Interfoliada'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilleta-coctel/',
                'categoria'             => 'Servilleta Coctel'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-lunch/',
                'categoria'             => 'Servilleta Lunch'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/dispensadores-servilletas/',
                'categoria'             => 'Dispensador de Servilletas'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/higenicos/dispensadores-higienicos/',
                'categoria'             => 'Dispensador Higienico'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/jabones/dispensadores-jabones/',
                'categoria'             => 'Dispensador Jabones'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/toallas/dispensadores-toallas/',
                'categoria'             => 'Dispensador Toalla'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/incontinencia/incontinencia-hombres/',
                'categoria'             => 'Incontinencia Hombres',
                'producto'              => 'Pañal'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/elementos-proteccion-personal/proteccion-piel/',
                'categoria'             => 'Proteccion Piel',
                'producto'              => 'Alcohol'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.hygiene.cl/categoria-producto/alimentaria/lavalozas/',
                'categoria'             => 'Lavalozas'
            ],
        );
        if($this->validarDataPorFecha(13, true)){
            foreach ($categoriasLink as $categoriaLink) {

                $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $categoriaLink->categoria;

                $crawler->filter(".classic")->each(function($node) use($tituloCategoria, $pagId){
                    $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
                    $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']")->text();
                    $urlProducto = $node->filter(".product-wrap > a")->attr('href');
                    $precioProducto = $node->filter("[class='price']")->text();
                    
                    $fecid = $this->validarDataPorFecha(13);

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $nombreProducto;
                    $dtpdatospaginas->dtpurl       = $urlProducto;
                    $dtpdatospaginas->dtpimagen    = $imagenProducto;
                    $dtpdatospaginas->dtpprecio    = $precioProducto;
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->save(); 
                });
            }
        }
    }

    public function MetObtenerCentralMayorista()
    {
        $pagId = 14;
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
                'id'        => '63489',
                'categoria' => 'Jabones'
            ],
            (object)
            [
                'id'        => '63531',
                'categoria' => 'Toallas de Papel'
            ],
            (object)
            [
                'id'        => '63530',
                'categoria' => 'Servilletas'
            ],
            (object)
            [
                'id'        => '63529',
                'categoria' => 'Papel Higiénico'
            ],
            (object)
            [
                'id'        => '63545',
                'categoria' => 'Pañales Bebe'
            ],
            (object)
            [
                'id'        => '63494',
                'categoria' => 'Cuidado Adulto Mayor',
                'productos' => 'Pañales Adulto'
            ],
            (object)
            [
                'id'        => '63534',
                'categoria' => 'Limpiadores Hogar',
                'productos' => 'Desengrasantes/Limpiavidrios/Lavalozas'
            ],
            (object)
            [
                'id'        => '63533',
                'categoria' => 'Accesorios Aseo',
                'productos' => 'Wipes'
            ],
        );
        foreach ($categorias as $categoria) 
        {
            $id = $categoria->id;
            $tituloCategoria = $categoria->categoria;

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

                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid        = $pagId;
                    $dtpdatospaginas->fecid        = $fecid;
                    $dtpdatospaginas->dtpnombre    = $producto->name;
                    $dtpdatospaginas->dtppagina    = $pagina;
                    $dtpdatospaginas->dtpimagen    = $producto->photosUrls[0];
                    $dtpdatospaginas->dtpprecio    = $producto->price;
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->dtpsku       = $producto->sku;
                    $dtpdatospaginas->dtpstock     = $producto->stock;
                    $dtpdatospaginas->dtpdesclarga = $producto->description;
                    $dtpdatospaginas->save(); 
                }
            }
            
        }
    }

    public function MetObtenerCuponatic()
    {
        $pagId = 15;
        $categorias = array('productos','servicios','gastronomia');
        foreach ($categorias as $categoria) {
            $urlCategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/menu/seccion/$categoria?ciudad=Santiago";
            $datosCategoria = \Httpful\Request::get($urlCategoria)
                                    ->sendsJson()
                                    ->send();
            $subcategorias = array(
                (object)
                [ 
                    'slug'      => 'aseo-y-limpieza',
                    'categoria' => 'Aseo y Limpieza',
                    'producto'  => 'Papel Higienico / Dispensador / Alcohol Gel / Lavalozas / Limpiavidrio / Desengrasante / Dispensador Jabon'
                ],
                (object)
                [
                    'slug'      => 'cuidado-de-la-piel',
                    'categoria' => 'Cuidado de la Piel',
                    'producto'  => 'Jabon'
                ],
                (object)
                [
                    'slug'      => 'otros-cocina',
                    'categoria' => 'Otros Cocina',
                    'producto'  => 'Dispensador Toalla / Servilleta / Dispensador Agua Purificada'
                ],
                (object)
                [
                    'slug'      => 'utensilios',
                    'categoria' => 'Utensilios',
                    'producto'  => 'Dispensador Agua'
                ],
                (object)
                [
                    'slug'      => 'higiene',
                    'categoria' => 'Higiene',
                    'producto'  => 'Servilleta'
                ],
                (object)
                [
                    'slug'      => 'para-el-bano',
                    'categoria' => 'Para el baño',
                    'producto'  => 'Dispensador Automatico'
                ],

            );
            foreach ($subcategorias as $subcategoria) {
                $slug = $subcategoria->slug;
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

                            $dtpdatospaginas = new dtpdatospaginas();
                            $dtpdatospaginas->pagid        = $pagId;
                            $dtpdatospaginas->fecid        = $fecid;
                            $dtpdatospaginas->dtpnombre    = $productosSubcategoria->titulo;
                            $dtpdatospaginas->dtppagina    = $numeroPaginas;
                            $dtpdatospaginas->dtpimagen    = $productosSubcategoria->imagen;
                            $dtpdatospaginas->dtpprecio    = $productosSubcategoria->valor_oferta;
                            $dtpdatospaginas->dtpcategoria = $categoria;
                            $dtpdatospaginas->dtpurl       = $productosSubcategoria->url_desktop;
                            $dtpdatospaginas->dtpstock     = $productosSubcategoria->estado_venta;
                            $dtpdatospaginas->dtpmarca     = $productosSubcategoria->marcas;
                            $dtpdatospaginas->save(); 
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
