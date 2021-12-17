<?php

namespace App\Http\Controllers;
use Goutte\Client;

class ScraperController extends Controller
{
    public function arcalauquen(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";
        // $papelHigienico = 'https://www.arcalauquen.cl/15-papel-higienico?page=1';
        // $toalla = 'https://www.arcalauquen.cl/16-toallas?page=1';
        // $jabon = 'https://www.arcalauquen.cl/8-detergentes-desinfectantes-y-jabones?page=1';
        // $servilleta = 'https://www.arcalauquen.cl/19-servilletas?page=1';
        // $panuelo = 'https://www.arcalauquen.cl/20-panuelos-desechables?page=1';
        // $sabanilla = 'https://www.arcalauquen.cl/17-sabanillas?page=1';
        // $panosLimpieza = 'https://www.arcalauquen.cl/18-panos-de-limpieza?page=1';
        $pagId = 1;
        $categoriasLink = array(
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/15-papel-higienico?page=1'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/16-toallas?page=1'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/8-detergentes-desinfectantes-y-jabones?page=1'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/19-servilletas?page=1'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/20-panuelos-desechables?page=1'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/17-sabanillas?page=1'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.arcalauquen.cl/18-panos-de-limpieza?page=1'
            ]
            );
            // dd($categoriasLink);
        foreach ($categoriasLink as $categoriaLink) {    
            $paginaURLPages = $categoriaLink->linkCategoriaProducto;
            $crawler = $client->request('GET', $paginaURLPages);
            $posicion = $crawler->filter(".page-list > li")->count()-2;
            $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');
            for($i=1; $i<=$numeroPaginas; ++$i)
            {
                $nuevaURLPage = explode('=', $paginaURLPages);
                //OBTENGO LA URL DE LA PAGINA SIN EL NUMERO 1
                $stringSeleccionado = $nuevaURLPage[0];
                $paginaURL = "$stringSeleccionado=$i";
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter("[class='h1 page-title']")->first()->text();
                $pagina = $i;
                echo 'PÁGINA '.$i. '<br>';
                echo $tituloCategoria . '<br><br>';

                $crawler->filter(".js-product-miniature-wrapper")->each(function($node) use($pagina, $tituloCategoria, $pagId){
                    $imagenProducto = $node->filter(".product-thumbnail > img")->attr('data-src');
                    $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                    $precioProducto = $node->filter("[class='product-price-and-shipping']")->text();
                    $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                    $descProducto = $node->filter(".product-description-short")->text();
                    $stockProducto = $node->filter("[class='product-availability d-block']")->text();
                    $skuProducto = $node->filter("[class='product-reference text-muted']")->text();

                    echo 'Página ID: ' .$pagId.'<br>';
                    echo 'Página: ' .$pagina.'<br>';
                    echo 'Titulo Categoria: ' .$tituloCategoria.'<br>';
                    echo 'SKU Producto: '. $skuProducto . '<br>';
                    echo 'stock Producto: '. $stockProducto . '<br>';
                    echo 'Nombre Producto: '. $nombreProducto. '<br>';
                    echo 'Precio: '. $precioProducto . '<br>';
                    echo 'Descripcion: '. $descProducto . '<br>';
                    echo 'URL Producto: ';
                    var_dump($urlProducto);
                    echo  '<br>';
                    echo 'Imagen: ';
                    var_dump($imagenProducto);
                    echo '<br><br>';
                });
            }
        }
    }

    public function tork(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";
        
            $papelHigienico = 'https://torkalpormayor.cl/collections/papel-higienico';
            $toalla = 'https://torkalpormayor.cl/collections/toalla-en-rollo';
            $toallaInterfoleada = 'https://torkalpormayor.cl/collections/toalla-interfoliada';
            $jabon = 'https://torkalpormayor.cl/collections/jabon';
            $servilleta = 'https://torkalpormayor.cl/collections/insumos/servilletas';
            $sabanillaMedica = 'https://torkalpormayor.cl/collections/sabanilla-medica';

            $paginaURL = $sabanillaMedica;
            $crawler = $client->request('GET', $paginaURL);

            $crawler->filter(".product-grid-item")->each(function($node){
                $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
                $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']");
                $precioProducto = $node->filter("[class='money']");
                $urlProducto = $node->filter(".lazy-image")->attr('href');

                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio: '. $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
    }

    public function dipisa(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";
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

        foreach ($categoriasLink as $categoriaLink) {
            // $papelHigienico = 'https://dipisa.cl/tipo_tissues/papel-higienico/';
            // $toallasPapel = 'https://dipisa.cl/tipo_tissues/toallas-de-papel/';
            // $dispensador = 'https://dipisa.cl/tipo_tissues/dispensador/';
            // $sabanilla = 'https://dipisa.cl/tipo_tissues/sabanilla/';

            $paginaURL = $categoriaLink->linkCategoriaProducto;
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='col-md-12 text-center']")->first();
            echo $tituloCategoria->text() . '<br><br>';

            $crawler->filter("[class='col-md-4 mb50']")->each(function($node){
                $imagenProducto = $node->filter(".box-contenido > img")->attr('src');
                $nombreProducto = $node->filter("h5")->text();
                $nombre = explode ("Un.", $nombreProducto);
                
                $precioProducto = explode("Precio:", $nombreProducto);
                $marcaProducto = $node->filter(".box-contenido > h4")->text();
                $skuProducto = $node->filter("p > span")->text();

                $nombreCompleto = $marcaProducto .' '. $nombre[0];

                echo 'Nombre Producto : '. $nombreCompleto . '<br>';
                echo 'Precio Producto : '. $precioProducto[1] . '<br>';
                echo 'Marca Producto: '. $marcaProducto . '<br>';
                echo 'SKU Producto: '. $skuProducto . '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
        }
    }

    public function avalco(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://www.avalco.cl/167-papel-higienico?page=1';
        $papelHigienicoJumbo = 'https://www.avalco.cl/165-papel-higienico-jumbo?page=1';
        $toallasInterfoliadas = 'https://www.avalco.cl/166-toallas-interfoliadas?page=1';
        $papelHigienicoToallasPapel = 'https://www.avalco.cl/61-papeles-higienicos-y-toallas-de-papel?page=1';
        $jabon = 'https://www.avalco.cl/73-jabones?page=1';
        $servilleta = 'https://www.avalco.cl/126-servilletas-de-papel?page=1';
        $dispensadorJabon = 'https://www.avalco.cl/22-dispensadores-de-jabon?page=1';
        $dispensadorPapel = 'https://www.avalco.cl/23-dispensadores-de-papel?page=1';
        $alcoholDesnaturalizado = 'https://www.avalco.cl/139-alcohol-desnaturalizado?page=1';
        $alcoholEtilico = 'https://www.avalco.cl/131-alcohol-etilico?page=1';
        $alcoholGel = 'https://www.avalco.cl/129-alcohol-gel?page=1';
        $alcoholIsopropilico = 'https://www.avalco.cl/130-alcohol-isopropilico?page=1';
        $desengrasante = 'https://www.avalco.cl/40-desengrasantes?page=1';

        $paginaURLPages = $desengrasante;
        $crawler = $client->request('GET', $paginaURLPages);
        $posicion = $crawler->filter(".page-list > li")->count()-2;
        $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');

        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://www.avalco.cl/40-desengrasantes?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='page-heading js-category-page']")->first();
            echo 'PÁGINA '.$i. '<br>';
            echo $tituloCategoria->text() . '<br><br>';
            
            $crawler->filter("[class='product-miniature product-style js-product-miniature']")->each(function($node){
                $imagenProducto = $node->filter(".product-cover-link > img")->attr('src');
                $nombreProducto = $node->filter(".product-name");
                $precioProducto = $node->filter("[class='price product-price']");
                $urlProducto = $node->filter(".product-name > a")->attr('href');
                $stringSkuProducto = $node->filter(".second-block > h4")->text();
                $skuProducto = explode ("Ref:", $stringSkuProducto);
                $stockProducto = $node->filter(".available")->text('-');
                $descProducto = $node->filter(".product-description-short")->text();

                echo 'Desc Producto: ' . $descProducto . '<br>';
                echo 'SKU Producto: '. $skuProducto[1] . '<br>';
                echo 'Stock Producto: ' . $stockProducto . '<br>';
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: '. $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
        }
    }

    public function dilen(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://dilenchile.cl/categoria-producto/papel-higienico/';
        $toallaPapel = 'https://dilenchile.cl/categoria-producto/toalla-de-papel/';
        $jabon = 'https://dilenchile.cl/categoria-producto/jabones/';
        $dispensadorPHBajoMetraje= 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-bajo-metraje/';
        $dispensadorPHBajoMetrajeInterfoliado = 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-bajo-metraje-interfoliado/';
        $dispensadorPHAltoMetraje = 'https://dilenchile.cl/categoria-producto/papel-higienico/dispensador-papel-higienico-alto-metraje/';
        $dispensadorServilletaExpress = 'https://dilenchile.cl/categoria-producto/servilleta/dispensador-servilleta-express/';
        $dispensadorServilletaMesa = 'https://dilenchile.cl/categoria-producto/servilleta/dispensador-servilleta-mesa/';
        $dispensadorSabanilla = 'https://dilenchile.cl/categoria-producto/sabanillas/dispensador-sabanillas/';
        $dispensadorCobertorWC = 'https://dilenchile.cl/categoria-producto/accesorios-de-bano/cobertor-w-c/dispensador-cobertor-w-c/';
        $dispensadorJabonRellenable = 'https://dilenchile.cl/categoria-producto/jabones/jabon-rellenable/dispensador-jabon-rellenable/';
        $dispensadorJabonMultiflex = 'https://dilenchile.cl/categoria-producto/jabones/jabon-multiflex/dispensador-jabon-multiflex/';
        $dispensadorPanosLimpieza = 'https://dilenchile.cl/categoria-producto/panos-de-limpieza/dispensador-panos-de-limpieza/';
        $servilleta = 'https://dilenchile.cl/categoria-producto/servilleta/';
        $sabanilla = 'https://dilenchile.cl/categoria-producto/sabanillas/';
        $panialAdulto = 'https://dilenchile.cl/categoria-producto/panal-para-adultos/';
        $paniosLimpieza = 'https://dilenchile.cl/categoria-producto/panos-de-limpieza/';
        $alcoholGel  = 'https://dilenchile.cl/categoria-producto/higiene-y-cuidados/alcohol-gel/';
        $lavaloza = 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/lavalozas/';
        $limpiaVidrios = 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/limpiavidrios/';
        $desengrasante = 'https://dilenchile.cl/categoria-producto/productos-de-limpieza/desengrasante/';

            $paginaURL = $desengrasante;
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".title");
            echo $tituloCategoria->text() . '<br><br>';

            $crawler->filter(".isotope-item")->each(function($node){
                $imagenProducto = $node->filter("[class='scale-with-grid wp-post-image']")->attr('src');
                $nombreProducto = $node->filter(".desc > h4");
                $urlProducto = $node->filter(".image_wrapper > a")->attr('href');
                $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']");
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
     
    }

    public function sodimac(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";
        
        $papelHigienico = 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=papel%2520higienico';
        $papelToalla = 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=toalla';
        $servilleta = 'https://www.sodimac.cl/sodimac-cl/search?Ntt=servilleta&currentpage=1';//se redirecciona porque solo hay un producto
        $dispensadorJabon = 'https://www.sodimac.cl/sodimac-cl/category/cat4850181?currentpage=1&=&f.product.attribute.Tipo=dispensadores%2520de%2520jabon';
        $dispensadorServilleta = 'https://www.sodimac.cl/sodimac-cl/search?Ntt=dispensador%20de%20servilleta?currentpage=1';
        $dispensadorPapelHigienico = 'https://www.sodimac.cl/sodimac-cl/category/scat963514/Limpieza?Ntt=dispensadores&sTerm=dispensadores&sType=category&sScenario=BTP_CAT_dispensadores&currentpage=1&f.product.attribute.Tipo=dispensador%2520papel%2520higienico';
        $jabon = 'https://www.sodimac.cl/sodimac-cl/category/scat963514/Limpieza?Ntt=jabones%20alcohol&sTerm=jabones&sType=category&sScenario=BTP_CAT_jabones%20alcohol&currentpage=1&f.product.attribute.Tipo=jabon';
        $sabanilla = 'https://www.sodimac.cl/sodimac-cl/category/cat9230001/Insumos-Medicos?currentpage=1';
        $alcohol = 'https://www.sodimac.cl/sodimac-cl/category/cat11540001/Proteccion-Sanitaria?currentpage=1&=&f.product.attribute.Tipo=alcohol%3A%3Aalcohol%2520gel';
        $lavaloza = 'https://www.sodimac.cl/sodimac-cl/category/cat4850292/Limpiadores-de-cocina?currentpage=1&=&f.product.attribute.Tipo=lavalozas';
        $limpiaVidrios = 'https://www.sodimac.cl/sodimac-cl/category/cat4850294/Limpiadores-Especificos?currentpage=1&=&f.product.attribute.Tipo=limpiavidrios';
        $desengrasante = 'https://www.sodimac.cl/sodimac-cl/search?Ntt=desengrasantes&currentpage=1&f.product.attribute.Tipo=desengrasante';

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
            // (object)
            // [
            //     'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4830002/Papeles?currentpage=1&=&f.product.attribute.Tipo=servilleta',
            //     'categoria'             => 'Servilleta'
            // ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/category/cat4850181?currentpage=1&=&f.product.attribute.Tipo=dispensadores%2520de%2520jabon',
                'categoria'             => 'Dispensador de Jabon'
            ],
            (object)
            [
                'linkCategoriaProducto' => 'https://www.sodimac.cl/sodimac-cl/search?Ntt=dispensador%20de%20servilleta',
                'categoria'             => 'Dispensador de Servilletas'
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

        $paginaURLPages = $servilleta;
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter("[class='jsx-4278284191 page-item page-index ']")->last()->text('1');

        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://www.sodimac.cl/sodimac-cl/search?Ntt=servilleta&currentpage=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='jsx-245626150 category-title']");
            echo $tituloCategoria->text('Desengrasantes') . '<br><br>';

            $crawler->filter("[class='jsx-411745769 product ie11-product-container']")->each(function($node){
                $imagenProducto = $node->filter("[class='image-contain ie11-image-contain  __lazy']")->attr('data-src');
                $nombreProducto = $node->filter("[class='jsx-411745769 product-title']");
                $marcaProducto = $node->filter("[class='jsx-411745769 product-brand']");
                $urlProducto = $node->filter("[class='jsx-4282314783 link link-primary ']")->attr('href');
                $precioProducto = $node->filter("[class='jsx-4135487716']");
                echo 'Marca Producto: '. $marcaProducto->text() . '<br>';
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
        }
    }

    public function dpronto(Client $client){
        echo "FECHA : " . date("d/m/Y") . "<br>";
       
        $dispensadorJabon = 'https://www.dpronto.cl/product-category/dispensadores-de-jabon/';
        $dispensadorPapelHigienico = 'https://www.dpronto.cl/product-category/dispensadores-de-jabon-papel-hig-toalla/';
        $jabon = 'https://www.dpronto.cl/product-category/productos-de-limpieza/jabones/';
        $papelHigienico = 'https://www.dpronto.cl/product-category/productos-de-limpieza/papeles-higienicos/';
        $toallaServilleta = 'https://www.dpronto.cl/product-category/productos-de-limpieza/toallas-de-papel-y-servilletas/';
        $lavalozasDesengrasante = 'https://www.dpronto.cl/product-category/productos-de-limpieza/lavalozas-y-desengrasantes/';
        $limpiavidrios = 'https://www.dpronto.cl/product-category/productos-de-limpieza/limpiavidrios/';
        $alcohol = 'https://www.dpronto.cl/product-category/productos-de-limpieza/desinfectantes-sanitizantes-enzimaticos/';

        $paginaURL = $alcohol;
        $crawler = $client->request('GET', $paginaURL);
        $stringtituloCategoria = $crawler->filter("[class='woocommerce-breadcrumb breadcrumbs uppercase']")->text();
        $tituloCategoria = explode('/',$stringtituloCategoria);
        echo $tituloCategoria[1] . '<br><br>';

        $crawler->filter("[class='product-small box ']")->each(function($node){
            $imagenProducto = $node->filter(".image-zoom > a > img")->attr('data-src');
            $nombreProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->text();
            $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
            $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']");
               echo 'Nombre Producto: '. $nombreProducto . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
        });
    }

    public function comcer(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://www.comcer.cl/store/categoria-producto/papeles/papeles-higienicos-formato-hogar-y-jumbo/';
        $toallaPapel = 'https://www.comcer.cl/store/categoria-producto/papeles/toalla-de-papel/';
        $sabanilla = 'https://www.comcer.cl/store/categoria-producto/papeles/sabanillas/';
        $servilleta = 'https://www.comcer.cl/store/categoria-producto/papeles/servilletas/';
        $dispensador = 'https://www.comcer.cl/store/categoria-producto/dispensadores/';
        $jabonGel = 'https://www.comcer.cl/store/categoria-producto/jabones/';
        $panos = 'https://www.comcer.cl/store/categoria-producto/panos/';
        $alcoholJabonGel = 'https://www.comcer.cl/store/categoria-producto/proteccion-covid-19/jabon-y-alcohol-gel/';
        $lavalozaDesengrasante = 'https://www.comcer.cl/store/categoria-producto/detergentes/lavalozas/';

            $paginaURL = $lavalozaDesengrasante;
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='woocommerce-products-header__title page-title']");
            echo $tituloCategoria->text() . '<br><br>';

            $crawler->filter(".products > li")->each(function($node){
                $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
                $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']");
                $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
                $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']");
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
    }
    
    public function ofimaster(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://www.ofimaster.cl/papel-tissue/papel-higienico?page=1';
        $toallaPapel = 'https://www.ofimaster.cl/papel-tissue/toalla-de-papel?page=1';
        $jabon = 'https://www.ofimaster.cl/quimicos-de-limpieza/jabones?page=1';
        $dispensadorAromas = 'https://www.ofimaster.cl/dispensadores/de-aromas?page=1';
        $dispensadorJabon = 'https://www.ofimaster.cl/dispensadores/de-jabon?page=1';
        $dispensadorPapelHigienico = 'https://www.ofimaster.cl/dispensadores/de-papel-higiienico?page=1';
        $dispensadorToalla = 'https://www.ofimaster.cl/dispensadores/de-toalla-de-papel?page=1';
        $servilleta = 'https://www.ofimaster.cl/papel-tissue/servilletas?page=1';
        $sabanilla = 'https://www.ofimaster.cl/search?q=sabanilla&page=1';
        $paño = 'https://www.ofimaster.cl/search?q=pa%C3%B1o&page=1';
        $panuelo = 'https://www.ofimaster.cl/search?q=pa%C3%B1uelo%7D&page=1';
        $alcohol = 'https://www.ofimaster.cl/search?q=alcohol&page=1';
        $lavaloza = 'https://www.ofimaster.cl/search?q=lavaloza&page=1';
        $limpiavidrio = 'https://www.ofimaster.cl/search?q=limpiavidrio&page=1';
        $desengrasante = 'https://www.ofimaster.cl/search?q=desengrasante&page=1';

        $paginaURLPages = $sabanilla;
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter('.count > span')->last()->text('1');

        for($i=1; $i<=$numeroPaginas; ++$i){

            $paginaURL = "https://www.ofimaster.cl/search?q=sabanilla&page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".page-title");
            echo 'PÁGINA '.$i. '<br>';
            echo $tituloCategoria->text() . '<br><br>';
            
            $crawler->filter("[class='product-block']")->each(function($node){
                $imagenProducto = $node->filter("[class='img-fluid']")->attr('src');
                $nombreProducto = $node->filter("[class='brand-name trsn']");
                $marcaProducto = $node->filter("[class='brand']");
                $urlProducto = $node->filter(".product-block > a")->attr('href');
                $precioProducto = $node->filter("[class='block-price']");
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Marca Producto: '. $marcaProducto->text('-') . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
        }
    }

    public function daos(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://daos.cl/home/15-papel-higienico';
        $toallaPapel = 'https://daos.cl/home/17-toalla-de-papel';
        $lavaloza = 'https://daos.cl/home/21-lavalozas';
        $jabonLiquido = 'https://daos.cl/home/70-jabon-liquido';
        $jabonBarra = 'https://daos.cl/home/71-jabon-en-barra';
        $desengrasante = 'https://daos.cl/home/22-antigrasa';
        $limpividrio = 'https://daos.cl/home/27-limpiadores';
        $alcoholGel = 'https://daos.cl/home/101-alcohol-gel';

        $paginaURLPages = $desengrasante;
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter(".page-list > li")->eq(4)->text('1');
        
        for($i=1; $i<=$numeroPaginas; ++$i){
            $paginaURL = "https://daos.cl/home/22-antigrasa?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".h2");
            echo 'PÁGINA '.$i. '<br>';
            echo $tituloCategoria->text() . '<br><br>';
           // 
            $crawler->filter("[class='thumbnail-container']")->each(function($node){
                $imagenProducto = $node->filter("[class='ttproduct-img1']")->attr('src');
                $nombreProducto = $node->filter("[class='h3 product-title']");
                $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                $precioProducto = $node->filter("[class='price']");
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
        }
    }

    public function provit(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://provit.cl/categorias/10/papel-higienico/9999/0/0/9999/0/9/pagina-1';
        $toallaEnRollo = 'https://provit.cl/categorias/12/tollas-en-rollo/9999/0/0/9999/0/9/pagina-1';
        $toallaInterfoleada = 'https://provit.cl/categorias/13/toallas-interfoliadas/9999/0/0/9999/0/9/pagina-1';
        $sabanilla = 'https://provit.cl/categorias/14/sabanillas/9999/0/0/9999/0/9/pagina-1';
        $jabon = 'https://provit.cl/categorias/1/jabon/9999/0/0/9999/0/9/pagina-1';
        $dispensador = 'https://provit.cl/lineas/1/dispensadores/9999/0/0/9999/0/9/pagina-1';
        $servilleta = 'https://provit.cl/categorias/11/servilletas/9999/0/0/9999/0/9/pagina-1';
        $panos = 'https://provit.cl/categorias/3/panos/9999/0/0/9999/0/9/pagina-1';
        $alcohol = 'https://provit.cl/busquedas/alcohol/9999/0/0/9999/0/9/pagina-1';
        $lavaloza = 'https://provit.cl/busquedas/lavaloza/9999/0/0/9999/0/9/pagina-1';
        $limpiavidrio = 'https://provit.cl/busquedas/limpiavidrio/9999/0/0/9999/0/9/pagina-1';
        $desengrasante = 'https://provit.cl/busquedas/desengrasante/9999/0/0/9999/0/9/pagina-1';

        $paginaURLPages = $desengrasante;
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter(".paginate")->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i){
            $paginaURL = "https://provit.cl/busquedas/desengrasante/9999/0/0/9999/0/9/pagina-$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloStringCategoria = $crawler->filter(".nomCategoria")->text();
            $tituloCategoria = explode ("(", $tituloStringCategoria);
            echo 'PÁGINA '.$i. '<br>';
            echo $tituloCategoria[0] . '<br><br>';
            
            $crawler->filter("[class='grilla']")->each(function($node){
                $imagenProducto = $node->filter(".imgGrilla > img")->attr('src');
                $nombreProducto = $node->filter("[class='nombreGrilla']");
                $urlProducto = $node->filter("[class='nombreGrilla']")->attr('href');
                $precioProducto = $node->filter("[class='conDescuento']");
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
        }
    }
    
    public function limpiamas(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://limpiamas.mercadoshops.cl/papel-higienico';
        $toallaPapel = 'https://limpiamas.mercadoshops.cl/toalla';
        $jabon = 'https://limpiamas.mercadoshops.cl/jabon';
        $dispensador = 'https://limpiamas.mercadoshops.cl/dispensador';
        $servilleta = 'https://limpiamas.mercadoshops.cl/servilleta';
        $sabanilla = 'https://limpiamas.mercadoshops.cl/sabanilla';
        $panal = 'https://limpiamas.mercadoshops.cl/pañal';
        $alcohol = 'https://limpiamas.mercadoshops.cl/alcohol';

            $paginaURL = $alcohol;
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".ui-search-breadcrumb__title");
            echo $tituloCategoria->text() . '<br><br>';
            
            $crawler->filter("[class='ui-search-result__wrapper']")->each(function($node){
                $imagenProducto = $node->filter(".slick-slide > img")->attr('src');
                $nombreProducto = $node->filter("[class='ui-search-item__title']");
                $urlProducto = $node->filter("[class='ui-search-item__group__element ui-search-link']")->attr('href');
                $precioProducto = $node->filter("[class='price-tag-amount']");
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
    }

    public function hygiene(Client $client){
        
        echo "FECHA : " . date("d/m/Y") . "<br>";

        $papelHigienico = 'https://www.hygiene.cl/categoria-producto/higenicos/';
        $toallaDoblada = 'https://www.hygiene.cl/categoria-producto/toallas/dobladas/';
        $toallaRollo = 'https://www.hygiene.cl/categoria-producto/toallas/toallas-rollo/';
        $toallaWipe = 'https://www.hygiene.cl/categoria-producto/toallas/wipe/';
        $jabon = 'https://www.hygiene.cl/categoria-producto/jabones/';
        $sabanilla = 'https://www.hygiene.cl/categoria-producto/otros-papeles/sabanillas-medicas/';
        $desengrasante = 'https://www.hygiene.cl/categoria-producto/desengrasantes/';
        $panos = 'https://www.hygiene.cl/categoria-producto/accesorios-superficies/panos/';
        $panuelos = 'https://www.hygiene.cl/categoria-producto/otros-papeles/panuelos-faciales/';
        $servilletaGourmet = 'https://www.hygiene.cl/categoria-producto/servilletas-gourmet/';
        $servilletaMesa = 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-mesa/';
        $servilletaInterfoliada = 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-interfoliadas/';
        $servilletaCoctel ='https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilleta-coctel/';
        $servilletaLunch = 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/servilletas-lunch/';
        $dispensadorServilleta = 'https://www.hygiene.cl/categoria-producto/alimentaria/servilletas/dispensadores-servilletas/';
        $dispensadorHigienico = 'https://www.hygiene.cl/categoria-producto/higenicos/dispensadores-higienicos/';
        $dispensadorJabones = 'https://www.hygiene.cl/categoria-producto/jabones/dispensadores-jabones/';
        $dispensadorToalla = 'https://www.hygiene.cl/categoria-producto/toallas/dispensadores-toallas/';
        $panal = 'https://www.hygiene.cl/categoria-producto/incontinencia/incontinencia-hombres/';
        $alcohol = 'https://www.hygiene.cl/categoria-producto/elementos-proteccion-personal/proteccion-piel/';
        $lavaloza = 'https://www.hygiene.cl/categoria-producto/alimentaria/lavalozas/';

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
        foreach ($categoriasLink as $categoriaLink) {

            $paginaURL = $categoriaLink->linkCategoriaProducto;
                $crawler = $client->request('GET', $paginaURL);
                $tituloCategoria = $crawler->filter(".page-title");
                echo $tituloCategoria->text('-') . '<br>';
                echo '<br>';

                $crawler->filter(".classic")->each(function($node){
                    $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
                    $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']");
                    $urlProducto = $node->filter(".product-wrap > a")->attr('href');
                    $precioProducto = $node->filter("[class='price']")->text();

                    if ( strpos($precioProducto,"–")) {
                        $precioString = explode("+",$precioProducto);
                        $precioStringFinal = trim($precioString[0]);
                    }else{
                        $precioString = explode("$",$precioProducto);
                        $precioString2 = explode("+",$precioString[1]);
                        $precioStringFinal = trim($precioString2[0]);
                    }

                    echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                    echo 'Precio Producto: ' . $precioStringFinal . '<br>';
                    echo 'URL Producto: ';
                    var_dump($urlProducto);
                    echo  '<br>';
                    echo 'Imagen: ';
                    var_dump($imagenProducto);
                    echo '<br><br>';
                });
        }
    }

    public function mercado(){
        echo "FECHA : " . date("d/m/Y") . "<br>";

        $url = 'https://deadpool.instaleap.io/api/v2';
        $queryCategorias = array('operationName'=>'getStore','variables'=>['clientId'=>'CENTRAL_MAYORISTA'],'query'=>'query getStore($storeId: ID, $clientId: String) {  getStore(storeId: $storeId, clientId: $clientId) {    id    name    categories {      id      image      slug      name      redirectTo      isAvailableInHome      __typename    }    banners {      id      title      desktopImage      mobileImage      targetCategory      targetUrl {        url        type        __typename      }      __typename    }    __typename  }}');
        $queryCategoriasJson = json_encode($queryCategorias);
        $datosCategorias = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($queryCategoriasJson)
                            ->send();
       $store = $datosCategorias->body->data->getStore->id;
    //    $categorias = $datosCategorias->body->data->getStore->categories; 
    //    dd($categorias);   
        //63526 Limpieza Y Aseo
        //63485 Cuidado e Higiene Personal
        //63542 Mundo Bebé
        $categoriasRequeridas = array(
            (object)
            [ 
                'id' => '63489',
                'name' => 'Jabones'
            ],
            (object)
            [
                'id' => '63531',
                'name' => 'Toallas de Papel'
            ],
            (object)
            [
                'id' => '63530',
                'name' => 'Servilletas'
            ],
            (object)
            [
                'id' => '63529',
                'name' => 'Papel Higiénico'
            ],
            (object)
            [
                'id' => '63545',
                'name' => 'Pañales Bebe'
            ],
            (object)
            [
                'id' => '63494',
                'name' => 'Pañales Adulto'
            ],
            (object)
            [
                'id' => '63534',
                'name' => 'Limpiadores Hogar'
            ],
            (object)
            [
                'id' => '63533',
                'name' => 'Wipes / Accesorios Aseo'
            ],
        );
        foreach ($categoriasRequeridas as $categoria) {
            $id = $categoria->id;
            echo 'Categoria: '. $categoria->name . '<br><br>';

            $queryProductosObtenerPaginas = array('variables'=> ['categoryId'=> $id,'onlyThisCategory'=>false,'pagination'=>['pageSize'=>30,'currentPage'=>1],'storeId'=>$store],'query'=>'query ($pagination: paginationInput, $search: SearchInput, $storeId: ID!, $categoryId: ID, $onlyThisCategory: Boolean, $filter: ProductsFilterInput, $orderBy: productsSortInput) {  getProducts(pagination: $pagination, search: $search, storeId: $storeId, categoryId: $categoryId, onlyThisCategory: $onlyThisCategory, filter: $filter, orderBy: $orderBy) {    redirectTo    products {      id      description      name      photosUrls      sku      unit      price      specialPrice      promotion {        description        type        isActive        conditions        __typename      }      stock      nutritionalDetails      clickMultiplier      subQty      subUnit      maxQty      minQty      specialMaxQty      ean      boost      showSubUnit      isActive      slug      categories {        id        name        __typename      }      __typename    }    paginator {      pages      page      __typename    }    __typename  }}');
            $queryProductosObtenerPaginasJson = json_encode($queryProductosObtenerPaginas);
            $datosProductos1 = \Httpful\Request::post($url)
                                    ->sendsJson()
                                    ->body($queryProductosObtenerPaginasJson)
                                    ->send();
            // dd($datosProductos1);
            
            $paginas =$datosProductos1->body->data->getProducts->paginator->pages;

            for($i=1; $i<=$paginas;$i++)
            {
                $queryProductos = array('variables'=> ['categoryId'=> $id,'onlyThisCategory'=>false,'pagination'=>['pageSize'=>30,'currentPage'=>$i],'storeId'=>$store],'query'=>'query ($pagination: paginationInput, $search: SearchInput, $storeId: ID!, $categoryId: ID, $onlyThisCategory: Boolean, $filter: ProductsFilterInput, $orderBy: productsSortInput) {  getProducts(pagination: $pagination, search: $search, storeId: $storeId, categoryId: $categoryId, onlyThisCategory: $onlyThisCategory, filter: $filter, orderBy: $orderBy) {    redirectTo    products {      id      description      name      photosUrls      sku      unit      price      specialPrice      promotion {        description        type        isActive        conditions        __typename      }      stock      nutritionalDetails      clickMultiplier      subQty      subUnit      maxQty      minQty      specialMaxQty      ean      boost      showSubUnit      isActive      slug      categories {        id        name        __typename      }      __typename    }    paginator {      pages      page      __typename    }    __typename  }}');
                $queryProductosJson = json_encode($queryProductos);
                $datosProductos = \Httpful\Request::post($url)
                                        ->sendsJson()
                                        ->body($queryProductosJson)
                                        ->send();
                $productos =$datosProductos->body->data->getProducts->products;
                // dd($productos);
                // $paginas =$datosProductos1->body->data->getProducts->paginator->pages;
                echo 'Páginas Totales: '. $paginas . '<br>'; 
                echo 'Página Actual: '. $i . '<br><br>'; 
                foreach ($productos as $producto) {
                        echo 'Nombre Producto: '. $producto->name . '<br>';
                        echo 'Precio Producto: ' . $producto->price . '<br>';
                        echo 'Imagen: ' . $producto->photosUrls[0] . '<br>';
                        echo 'SKU Producto: ' . $producto->sku . '<br>';
                        echo 'Stock Producto: ' . $producto->stock . '<br>';
                        echo 'Desc Producto: ' . $producto->description . '<br>';
                        echo '<br>';
            }
            }
            
        }
    }

    public function cuponatic(){
        
        echo "FECHA : " . date("d/m/Y") . "<br><br>";
        // $categorias = array('panoramas','productos','viajes-y-turismo','belleza','servicios','gastronomia','bienestar-y-salud');
        $categorias = array('productos');
        foreach ($categorias as $categoria) {
            $urlCategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/menu/seccion/$categoria?ciudad=Santiago";
            $datosCategoria = \Httpful\Request::get($urlCategoria)
                                    ->sendsJson()
                                    ->send();
            $subcategorias = $datosCategoria->body->hijos;
            $subcategoriasRequeridas = array(
                (object)
                [ 
                    'slug' => 'aseo-y-limpieza',
                    'producto' => 'papel higienico/ dispensador / alcohol gel / lavalozas/ limpiavidrio/ desengrasante / dispensador de jabon/ '
                ],
                (object)
                [
                    'slug' => 'cuidado-de-la-piel',
                    'producto' => 'jabon'
                ],
                (object)
                [
                    'slug' => 'otros-cocina',
                    'producto' => 'dispensador-toalla/ servilleta/dispensador-agua purificada'
                ],
                (object)
                [
                    'slug' => 'utensilios',
                    'producto' => 'dispensador-agua'
                ],
                (object)
                [
                    'slug' => 'higiene',
                    'producto' => 'servilleta'
                ],
                (object)
                [
                    'slug' => 'para-el-bano',
                    'producto' => 'dispensador automatico'
                ],

            );
            // dd($subcategorias);
            // echo 'CATEGORIA: '. $categoria . '<br><br>';
            foreach ($subcategoriasRequeridas as $subcategoria) {
                $slug = $subcategoria->slug;
                echo 'SUBCATEGORIA: '. $subcategoria->slug . '<br><br>';
                $encontroPagina = true;
                $numeroPaginas = 1;
                while($encontroPagina == true)
                {
                    $urlSubcategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/descuentos/menu/$slug?ciudad=Santiago&v=14&page=$numeroPaginas";
                    $datosSubcategoria = \Httpful\Request::get($urlSubcategoria)
                                            ->sendsJson()
                                            ->send();

                    $productosSubcategorias = $datosSubcategoria->body;
                    // dd($productosSubcategorias);
                    if(sizeof($productosSubcategorias)>0){
                        echo 'PÁGINA: '. $numeroPaginas . '<br><br>';
                        foreach ($productosSubcategorias as $productosSubcategoria) {
                            echo 'Nombre Producto: '. $productosSubcategoria->titulo . '<br>';
                            echo 'Imagen: ' . $productosSubcategoria->imagen . '<br>';
                            echo 'Precio Original Producto: ' . $productosSubcategoria->valor_original . '<br>';
                            echo 'Precio Oferta Producto: ' . $productosSubcategoria->valor_oferta . '<br>';
                            echo 'Marca: ' . $productosSubcategoria->marcas . '<br>';
                            echo 'Stock: ' . $productosSubcategoria->estado_venta . '<br>';
                            echo 'URL Producto: ' . $productosSubcategoria->url_desktop . '<br><br>';
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
