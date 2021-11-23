<?php

namespace App\Http\Controllers;
use Goutte\Client;

class ScraperController extends Controller
{
    public function arcalauquen(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";
        $papelHigienico = 'https://www.arcalauquen.cl/15-papel-higienico?page=1';
        $toalla = 'https://www.arcalauquen.cl/16-toallas?page=1';
        $jabon = 'https://www.arcalauquen.cl/8-detergentes-desinfectantes-y-jabones?page=1';
        $servilleta = 'https://www.arcalauquen.cl/19-servilletas?page=1';
        $panuelo = 'https://www.arcalauquen.cl/20-panuelos-desechables?page=1';
        $sabanilla = 'https://www.arcalauquen.cl/17-sabanillas?page=1';
        $panosLimpieza = 'https://www.arcalauquen.cl/18-panos-de-limpieza?page=1';

        // $paginaURLPages = "https://www.arcalauquen.cl/3-papeles?page=1";
        $paginaURLPages = $panosLimpieza;
        $crawler = $client->request('GET', $paginaURLPages);
        $posicion = $crawler->filter(".page-list > li")->count()-2;
        $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');
        // dd($numeroPaginas);
        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://www.arcalauquen.cl/18-panos-de-limpieza?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='h1 page-title']")->first();
            echo 'PÁGINA '.$i. '<br>';
            echo $tituloCategoria->text() . '<br><br>';

            $crawler->filter(".js-product-miniature-wrapper")->each(function($node) use($client){
                $imagenProducto = $node->filter(".product-thumbnail > img")->attr('data-src');
                $nombreProducto = $node->filter("[class='h3 product-title']");
                $precioProducto = $node->filter("[class='product-price-and-shipping']");
                $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                $descProducto = $node->filter(".product-description-short");

                // $crawler2 = $client->request('GET', $urlProducto);
                // $crawler2->filter("[class='col-md-6 col-product-info']")->each(function($node){
                //   echo 'STOCK: ' . $node->filter("#product-availability")->text() . '<br>';
                // });
                $stok = $node->filter("[class='product-availability d-block']")->text();
                $skuProducto = $node->filter("[class='product-reference text-muted']")->text();
                echo 'SKU Producto: '. $skuProducto . '<br>';
                echo 'stock Producto: '. $stok . '<br>';
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio: '. $precioProducto->text() . '<br>';
                echo 'Descripcion: '. $descProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });
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
            // $paginaURL = "https://torkalpormayor.cl/collections/insumos/toalla";
            $paginaURL = $sabanillaMedica;
            $crawler = $client->request('GET', $paginaURL);

            $crawler->filter(".product-grid-item")->each(function($node){
                $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
                $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']");
                $precioProducto = $node->filter("[class='money']");
                $urlProducto = $node->filter(".lazy-image")->attr('href');
                // $netoProducto = $node->filter(".price > span")->eq(2);
                
                // echo 'Neto Producto: '. $netoProducto->text() . '<br>';
                echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
                echo 'Precio: '. $precioProducto->text() . '<br>';
                echo 'URL Producto: ';
                var_dump($urlProducto);
                echo  '<br>';
                echo 'Imagen: ';
                var_dump($imagenProducto);
                echo '<br><br>';
            });

            // $crawler->filter("[class='grid__item  small--one-half medium--one-half large--one-third on-sale tagged product-grid-item']")->each(function($node){
            //     $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
            //     $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']");
            //     $precioProducto = $node->filter("[class='money']");
            //     $urlProducto = $node->filter(".lazy-image")->attr('href');
                
            //     echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
            //     echo 'Precio: '. $precioProducto->text() . '<br>';
            //     echo 'URL Producto: ';
            //     var_dump($urlProducto);
            //     echo  '<br>';
            //     echo 'Imagen: ';
            //     var_dump($imagenProducto);
            //     echo '<br><br>';
            // });
            
            // $crawler->filter("[class='grid__item  small--one-half medium--one-half large--one-third tagged product-grid-item']")->each(function($node){
            //     $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
            //     $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']");
            //     $precioProducto = $node->filter("[class='money']");
            //     $urlProducto = $node->filter(".lazy-image")->attr('href');
                
            //     echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
            //     echo 'Precio: '. $precioProducto->text() . '<br>';
            //     echo 'URL Producto: ';
            //     var_dump($urlProducto);
            //     echo  '<br>';
            //     echo 'Imagen: ';
            //     var_dump($imagenProducto);
            //     echo '<br><br>';
            // });
    }

    public function dipisa(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

            $papelHigienico = 'https://dipisa.cl/tipo_tissues/papel-higienico/';
            $toallasPapel = 'https://dipisa.cl/tipo_tissues/toallas-de-papel/';
            $dispensador = 'https://dipisa.cl/tipo_tissues/dispensador/';
            $sabanilla = 'https://dipisa.cl/tipo_tissues/sabanilla/';
            // $paginaURL = "https://dipisa.cl/tipo_tissues/papel-higienico/";
            $paginaURL = $sabanilla;
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
        // $paginaURLPages = "https://avalco.cl/131-alcohol-etilico?page=1";
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

            $paginaURL = $jabon;
            // $paginaURL = "https://dilenchile.cl/categoria-producto/papel-higienico/";
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
        
        $paginaURLPages = "https://www.sodimac.cl/sodimac-cl/category/cat4850182/papeles-y-dispensadores/";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter("[class='jsx-4278284191 page-item page-index ']")->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://www.sodimac.cl/sodimac-cl/category/cat4850182/papeles-y-dispensadores?currentpage=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='jsx-245626150 category-title']");
            echo $tituloCategoria->text() . '<br><br>';

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
       
        $paginaURL = "https://www.dpronto.cl/product-category/productos-de-limpieza/";
        $crawler = $client->request('GET', $paginaURL);
        $stringtituloCategoria = $crawler->filter("[class='woocommerce-breadcrumb breadcrumbs uppercase']")->text();
        $tituloCategoria = explode('/',$stringtituloCategoria);
        echo $tituloCategoria[1] . '<br><br>';
        //box-text box-text-products text-center grid-style-2
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

            
        // $paginaURLPages = "https://www.dpronto.cl/index.php?route=product/category&path=83_71";
        // $crawler = $client->request('GET', $paginaURLPages);
        // $posicion = $crawler->filter(".pagination > li")->count()-3;
        // $numeroPaginas = $crawler->filter(".pagination > li")->eq($posicion)->text();

        // for($i=1; $i<=$numeroPaginas; ++$i)
        // {
        //     $paginaURL = "https://www.dpronto.cl/index.php?route=product/category&path=83_71&page=$i";
        //     $crawler = $client->request('GET', $paginaURL);
        //     $tituloCategoria = $crawler->filter("#content > h1");
        //     echo 'PÁGINA '.$i. '<br>';
        //     echo $tituloCategoria->text() . '<br><br>';

        //     $crawler->filter("[class='product-thumb']")->each(function($node){
        //         $imagenProducto = $node->filter(".img-responsive")->attr('src');
        //         $nombreProducto = $node->filter(".caption > h4");
        //         $urlProducto = $node->filter(".image > a")->attr('href');
        //         $precioProducto = $node->filter(".price");
        //         echo 'Nombre Producto: '. $nombreProducto->text() . '<br>';
        //         echo 'Precio Producto: ' . $precioProducto->text() . '<br>';
        //         echo 'URL Producto: ';
        //         var_dump($urlProducto);
        //         echo  '<br>';
        //         echo 'Imagen: ';
        //         var_dump($imagenProducto);
        //         echo '<br><br>';
        //     });
        // }


    }

    public function comcer(Client $client){

        echo "FECHA : " . date("d/m/Y") . "<br>";

            $paginaURL = "https://www.comcer.cl/store/categoria-producto/dispensadores/";
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

        $paginaURLPages = "https://www.ofimaster.cl/papel-tissue?page=1";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter('.count > span')->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i){

            $paginaURL = "https://www.ofimaster.cl/papel-tissue?page=$i";
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
                echo 'Marca Producto: '. $marcaProducto->text() . '<br>';
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

        $paginaURLPages = "https://daos.cl/home/3-aseo-y-limpieza";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter(".page-list > li")->eq(4)->text();
        
        for($i=1; $i<=$numeroPaginas; ++$i){
            $paginaURL = "https://daos.cl/home/3-aseo-y-limpieza?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".h2");
            echo 'PÁGINA '.$i. '<br>';
            echo $tituloCategoria->text() . '<br><br>';
            
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

        $paginaURLPages = "https://provit.cl/lineas/2/papeles";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter(".paginate")->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i){
            $paginaURL = "https://provit.cl/lineas/2/papeles/9999/0/0/9999/0/9/pagina-$i";
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

            $paginaURL = "https://limpiamas.mercadoshops.cl/hogar/";
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

        $paginaURL = "https://www.hygiene.cl/categoria-producto/higenicos/";
        $crawler = $client->request('GET', $paginaURL);
        $tituloCategoria = $crawler->filter(".page-title");
        echo $tituloCategoria->text() . '<br>';
        echo '<br>';

        $crawler->filter(".classic")->each(function($node){
            $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
            $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']");
            $urlProducto = $node->filter(".product-wrap > a")->attr('href');
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
       $categorias = $datosCategorias->body->data->getStore->categories;    

        foreach ($categorias as $categoria) {
            $id = $categoria->id;
            echo 'Categoria: '. $categoria->name . '<br><br>';

            $queryProductosObtenerPaginas = array('variables'=> ['categoryId'=> $id,'onlyThisCategory'=>false,'pagination'=>['pageSize'=>30,'currentPage'=>1],'storeId'=>$store],'query'=>'query ($pagination: paginationInput, $search: SearchInput, $storeId: ID!, $categoryId: ID, $onlyThisCategory: Boolean, $filter: ProductsFilterInput, $orderBy: productsSortInput) {  getProducts(pagination: $pagination, search: $search, storeId: $storeId, categoryId: $categoryId, onlyThisCategory: $onlyThisCategory, filter: $filter, orderBy: $orderBy) {    redirectTo    products {      id      description      name      photosUrls      sku      unit      price      specialPrice      promotion {        description        type        isActive        conditions        __typename      }      stock      nutritionalDetails      clickMultiplier      subQty      subUnit      maxQty      minQty      specialMaxQty      ean      boost      showSubUnit      isActive      slug      categories {        id        name        __typename      }      __typename    }    paginator {      pages      page      __typename    }    __typename  }}');
            $queryProductosObtenerPaginasJson = json_encode($queryProductosObtenerPaginas);
            $datosProductos1 = \Httpful\Request::post($url)
                                    ->sendsJson()
                                    ->body($queryProductosObtenerPaginasJson)
                                    ->send();
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
        $categorias = array('panoramas','productos','viajes-y-turismo','belleza','servicios','gastronomia','bienestar-y-salud');
        foreach ($categorias as $categoria) {
            $urlCategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/menu/seccion/$categoria?ciudad=Santiago";
            $datosCategoria = \Httpful\Request::get($urlCategoria)
                                    ->sendsJson()
                                    ->send();
            $subcategorias = $datosCategoria->body->hijos;
            echo 'CATEGORIA: '. $categoria . '<br><br>';
            foreach ($subcategorias as $subcategoria) {
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
