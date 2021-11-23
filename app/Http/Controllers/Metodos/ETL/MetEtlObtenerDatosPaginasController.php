<?php

namespace App\Http\Controllers\Metodos\ETL;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use App\Models\fecfechas;
use DateTime;
use Illuminate\Http\Request;
use Goutte\Client;

class MetEtlObtenerDatosPaginasController extends Controller
{
    public function fecha()
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
        $paginaURLPages = "https://www.arcalauquen.cl/3-papeles?page=1";
        $crawler = $client->request('GET', $paginaURLPages);
        $posicion = $crawler->filter(".page-list > li")->count()-2;
        $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');

        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://www.arcalauquen.cl/3-papeles?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='h1 page-title']")->first()->text();
            $pagina = $i;

            $crawler->filter(".js-product-miniature-wrapper")->each(function($node) use($pagina, $tituloCategoria){
                $imagenProducto = $node->filter(".product-thumbnail > img")->attr('data-src');
                $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                $precioProducto = $node->filter("[class='product-price-and-shipping']")->text();
                $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                $descProducto = $node->filter(".product-description-short")->text();
                $stockProducto = $node->filter("[class='product-availability d-block']")->text();
                $skuProducto = $node->filter("[class='product-reference text-muted']")->text();

                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->fecid = $this->fecha();
                $dtpdatospaginas->pagid = 1;
                $dtpdatospaginas->dtpnombre = $nombreProducto;
                $dtpdatospaginas->dtpprecio = $precioProducto;
                $dtpdatospaginas->dtpurl = $urlProducto;
                $dtpdatospaginas->dtpimagen = $imagenProducto;
                $dtpdatospaginas->dtpdesclarga = $descProducto;
                $dtpdatospaginas->dtppagina = $pagina;
                $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                $dtpdatospaginas->dtpstock = $stockProducto;
                $dtpdatospaginas->dtpsku = $skuProducto;
                $dtpdatospaginas->save();
            });
        }
    }

    public function MetObtenerTork(Client $client)
    {
        $paginaURL = "https://torkalpormayor.cl/collections/insumos/toalla";
        $crawler = $client->request('GET', $paginaURL);

        $crawler->filter(".product-grid-item")->each(function($node){
            $imagenProducto = $node->filter(".lazy-image > img")->attr('data-src');
            $nombreProducto = $node->filter("[class='h5--accent strong name_wrapper']")->text();
            $precioProducto = $node->filter("[class='money']")->text();
            $urlProducto = $node->filter(".lazy-image")->attr('href');
            
            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 2;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto;
            $dtpdatospaginas->dtpurl = $urlProducto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;   
            $dtpdatospaginas->save();
        });
    }

    public function MetObtenerDipisa(Client $client)
    {
        $paginaURL = "https://dipisa.cl/tipo_tissues/papel-higienico/";
        $crawler = $client->request('GET', $paginaURL);
        $tituloCategoria = $crawler->filter("[class='col-md-12 text-center']")->first()->text();

        $crawler->filter("[class='col-md-4 mb50']")->each(function($node) use($tituloCategoria){
            $imagenProducto = $node->filter(".box-contenido > img")->attr('src');
            $nombrePrecioProducto = $node->filter("h5")->text();
            $nombreProducto = explode ("Un.", $nombrePrecioProducto);
            $precioProducto = explode("Precio:", $nombrePrecioProducto);
            $marcaProducto = $node->filter(".box-contenido > h4")->text();
            $skuProducto = $node->filter("p > span")->text();
            $nombreCompleto = $marcaProducto .' '. $nombreProducto[0];
            
            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 3;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreCompleto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;
            $dtpdatospaginas->dtpcategoria = $tituloCategoria;
            $dtpdatospaginas->dtpmarca = $marcaProducto;
            $dtpdatospaginas->dtpsku = $skuProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto[1];
            $dtpdatospaginas->save();
        });
    }

    public function MetObtenerAvalco(Client $client)
    {
        $paginaURLPages = "https://avalco.cl/131-alcohol-etilico?page=1";
        $crawler = $client->request('GET', $paginaURLPages);
        $posicion = $crawler->filter(".page-list > li")->count()-2;
        $numeroPaginas = $crawler->filter(".page-list > li")->eq($posicion)->text('1');

        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://avalco.cl/131-alcohol-etilico?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='page-heading js-category-page']")->first()->text();
            $pagina = $i;
            
            $crawler->filter("[class='product-miniature product-style js-product-miniature']")->each(function($node) use($tituloCategoria, $pagina){
                $imagenProducto = $node->filter(".product-cover-link > img")->attr('src');
                $nombreProducto = $node->filter(".product-name")->text();
                $precioProducto = $node->filter("[class='price product-price']")->text();
                $urlProducto = $node->filter(".product-name > a")->attr('href');
                $stringSkuProducto = $node->filter(".second-block > h4")->text();
                $skuProducto = explode ("Ref:", $stringSkuProducto);
                $stockProducto = $node->filter(".available")->text('-');
                $descProducto = $node->filter(".product-description-short")->text();

                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->pagid = 4;
                $dtpdatospaginas->fecid = $this->fecha();
                $dtpdatospaginas->dtpnombre = $nombreProducto;
                $dtpdatospaginas->dtpimagen = $imagenProducto;
                $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                $dtpdatospaginas->dtpurl = $urlProducto;
                $dtpdatospaginas->dtpprecio = $precioProducto;
                $dtpdatospaginas->dtppagina = $pagina;
                $dtpdatospaginas->dtpstock = $stockProducto;
                $dtpdatospaginas->dtpsku = $skuProducto[1];
                $dtpdatospaginas->dtpdesclarga = $descProducto;
                $dtpdatospaginas->save();
            });
        }
    }

    public function MetObtenerDilen(Client $client)
    {
        $paginaURL = "https://dilenchile.cl/categoria-producto/papel-higienico/";
        $crawler = $client->request('GET', $paginaURL);
        $tituloCategoria = $crawler->filter(".title")->text();

        $crawler->filter(".isotope-item")->each(function($node) use($tituloCategoria){
            $imagenProducto = $node->filter("[class='scale-with-grid wp-post-image']")->attr('src');
            $nombreProducto = $node->filter(".desc > h4")->text();
            $urlProducto = $node->filter(".image_wrapper > a")->attr('href');
            $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
            
            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 5;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreProducto;
            $dtpdatospaginas->dtpurl = $urlProducto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto;
            $dtpdatospaginas->dtpcategoria = $tituloCategoria;
            $dtpdatospaginas->save();
        });
    }

    public function MetObtenerSodimac(Client $client)
    {
        $paginaURLPages = "https://www.sodimac.cl/sodimac-cl/category/cat4850182/papeles-y-dispensadores/";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter("[class='jsx-4278284191 page-item page-index ']")->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i)
        {
            $paginaURL = "https://www.sodimac.cl/sodimac-cl/category/cat4850182/papeles-y-dispensadores?currentpage=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter("[class='jsx-245626150 category-title']")->text();
            $pagina = $i;

            $crawler->filter("[class='jsx-411745769 product ie11-product-container']")->each(function($node) use($tituloCategoria, $pagina){
                $imagenProducto = $node->filter("[class='image-contain ie11-image-contain  __lazy']")->attr('data-src');
                $nombreProducto = $node->filter("[class='jsx-411745769 product-title']")->text();
                $marcaProducto = $node->filter("[class='jsx-411745769 product-brand']")->text();
                $urlProducto = $node->filter("[class='jsx-4282314783 link link-primary ']")->attr('href');
                $precioProducto = $node->filter("[class='jsx-4135487716']")->text();

                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->pagid = 6;
                $dtpdatospaginas->fecid = $this->fecha();
                $dtpdatospaginas->dtpnombre = $nombreProducto;
                $dtpdatospaginas->dtpurl = $urlProducto;
                $dtpdatospaginas->dtpimagen = $imagenProducto;
                $dtpdatospaginas->dtpprecio = $precioProducto;
                $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                $dtpdatospaginas->dtpmarca = $marcaProducto;
                $dtpdatospaginas->dtppagina = $pagina;
                $dtpdatospaginas->save();
            });
        }
    }

    public function MetObtenerDpronto(Client $client)
    {
        $paginaURL = "https://www.dpronto.cl/product-category/productos-de-limpieza/";
        $crawler = $client->request('GET', $paginaURL);
        $stringtituloCategoria = $crawler->filter("[class='woocommerce-breadcrumb breadcrumbs uppercase']")->text();
        $tituloCategoria = explode('/',$stringtituloCategoria);
        $crawler->filter("[class='product-small box ']")->each(function($node) use($tituloCategoria){
            $imagenProducto = $node->filter(".image-zoom > a > img")->attr('data-src');
            $nombreProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->text();
            $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
            $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
            
            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 7;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreProducto;
            $dtpdatospaginas->dtpurl = $urlProducto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto;
            $dtpdatospaginas->dtpcategoria = $tituloCategoria[1];
            $dtpdatospaginas->save();   
        });
    }

    public function MetObtenerComcer(Client $client)
    {
        $paginaURL = "https://www.comcer.cl/store/categoria-producto/dispensadores/";
        $crawler = $client->request('GET', $paginaURL);
        $tituloCategoria = $crawler->filter("[class='woocommerce-products-header__title page-title']")->text();

        $crawler->filter(".products > li")->each(function($node) use($tituloCategoria){
            $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
            $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']")->text();
            $urlProducto = $node->filter("[class='woocommerce-LoopProduct-link woocommerce-loop-product__link']")->attr('href');
            $precioProducto = $node->filter("[class='woocommerce-Price-amount amount']")->text();
            
            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 8;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreProducto;
            $dtpdatospaginas->dtpurl = $urlProducto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto;
            $dtpdatospaginas->dtpcategoria = $tituloCategoria;
            $dtpdatospaginas->save();   
        });
    }

    public function MetObtenerOfimaster(Client $client)
    {
        $paginaURLPages = "https://www.ofimaster.cl/papel-tissue?page=1";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter('.count > span')->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i){

            $paginaURL = "https://www.ofimaster.cl/papel-tissue?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".page-title")->text();
            $pagina = $i;
            
            $crawler->filter("[class='product-block']")->each(function($node) use($tituloCategoria, $pagina){
                $imagenProducto = $node->filter("[class='img-fluid']")->attr('src');
                $nombreProducto = $node->filter("[class='brand-name trsn']")->text();
                $urlProducto = $node->filter(".product-block > a")->attr('href');
                $precioProducto = $node->filter("[class='block-price']")->text();
                $marcaProducto = $node->filter("[class='brand']")->text();

                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->pagid = 9;
                $dtpdatospaginas->fecid = $this->fecha();
                $dtpdatospaginas->dtpnombre = $nombreProducto;
                $dtpdatospaginas->dtpurl = $urlProducto;
                $dtpdatospaginas->dtpimagen = $imagenProducto;
                $dtpdatospaginas->dtpprecio = $precioProducto;
                $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                $dtpdatospaginas->dtppagina = $pagina;
                $dtpdatospaginas->dtpmarca = $marcaProducto;
                $dtpdatospaginas->save();   
            });
        }
    }

    public function MetObtenerDaos(Client $client)
    {
        $paginaURLPages = "https://daos.cl/home/3-aseo-y-limpieza";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter(".page-list > li")->eq(4)->text();
        
        for($i=1; $i<=$numeroPaginas; ++$i){
            $paginaURL = "https://daos.cl/home/3-aseo-y-limpieza?page=$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloCategoria = $crawler->filter(".h2")->text();
            $pagina = $i;
            
            $crawler->filter("[class='thumbnail-container']")->each(function($node) use($tituloCategoria, $pagina){
                $imagenProducto = $node->filter("[class='ttproduct-img1']")->attr('src');
                $nombreProducto = $node->filter("[class='h3 product-title']")->text();
                $urlProducto = $node->filter("[class='thumbnail product-thumbnail']")->attr('href');
                $precioProducto = $node->filter("[class='price']")->text();
                
                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->pagid = 10;
                $dtpdatospaginas->fecid = $this->fecha();
                $dtpdatospaginas->dtpnombre = $nombreProducto;
                $dtpdatospaginas->dtpurl = $urlProducto;
                $dtpdatospaginas->dtpimagen = $imagenProducto;
                $dtpdatospaginas->dtpprecio = $precioProducto;
                $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                $dtpdatospaginas->dtppagina = $pagina;
                $dtpdatospaginas->save();
            });
        }
    }

    public function MetObtenerProvit(Client $client)
    {
        $paginaURLPages = "https://provit.cl/lineas/2/papeles";
        $crawler = $client->request('GET', $paginaURLPages);
        $numeroPaginas = $crawler->filter(".paginate")->last()->text();

        for($i=1; $i<=$numeroPaginas; ++$i){
            $paginaURL = "https://provit.cl/lineas/2/papeles/9999/0/0/9999/0/9/pagina-$i";
            $crawler = $client->request('GET', $paginaURL);
            $tituloStringCategoria = $crawler->filter(".nomCategoria")->text();
            $tituloCategoria = explode ("(", $tituloStringCategoria);
            $pagina = $i;
            
            $crawler->filter("[class='grilla']")->each(function($node) use($tituloCategoria, $pagina){
                $imagenProducto = $node->filter(".imgGrilla > img")->attr('src');
                $nombreProducto = $node->filter("[class='nombreGrilla']")->text();
                $urlProducto = $node->filter("[class='nombreGrilla']")->attr('href');
                $precioProducto = $node->filter("[class='conDescuento']")->text();
                
                $dtpdatospaginas = new dtpdatospaginas();
                $dtpdatospaginas->pagid = 11;
                $dtpdatospaginas->fecid = $this->fecha();
                $dtpdatospaginas->dtpnombre = $nombreProducto;
                $dtpdatospaginas->dtpurl = $urlProducto;
                $dtpdatospaginas->dtpimagen = $imagenProducto;
                $dtpdatospaginas->dtpprecio = $precioProducto;
                $dtpdatospaginas->dtpcategoria = $tituloCategoria[0];
                $dtpdatospaginas->dtppagina = $pagina;
                $dtpdatospaginas->save();
            });
        }
    }

    public function MetObtenerLimpiamas(Client $client)
    {
        $paginaURL = "https://limpiamas.mercadoshops.cl/hogar/";
        $crawler = $client->request('GET', $paginaURL);
        $tituloCategoria = $crawler->filter(".ui-search-breadcrumb__title")->text();
        
        $crawler->filter("[class='ui-search-result__wrapper']")->each(function($node) use($tituloCategoria){
            $imagenProducto = $node->filter(".slick-slide > img")->attr('src');
            $nombreProducto = $node->filter("[class='ui-search-item__title']")->text();
            $urlProducto = $node->filter("[class='ui-search-item__group__element ui-search-link']")->attr('href');
            $precioProducto = $node->filter("[class='price-tag-amount']")->text();

            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 12;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreProducto;
            $dtpdatospaginas->dtpurl = $urlProducto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto;
            $dtpdatospaginas->dtpcategoria = $tituloCategoria;
            $dtpdatospaginas->save();    
        });
    }

    public function MetObtenerHygiene(Client $client){
        
        $paginaURL = "https://www.hygiene.cl/categoria-producto/higenicos/";
        $crawler = $client->request('GET', $paginaURL);
        $tituloCategoria = $crawler->filter(".page-title")->text();

        $crawler->filter(".classic")->each(function($node) use($tituloCategoria){
            $imagenProducto = $node->filter("[class='attachment-woocommerce_thumbnail size-woocommerce_thumbnail']")->attr('src');
            $nombreProducto = $node->filter("[class='woocommerce-loop-product__title']")->text();
            $urlProducto = $node->filter(".product-wrap > a")->attr('href');
            $precioProducto = $node->filter("[class='price']")->text();
            
            $dtpdatospaginas = new dtpdatospaginas();
            $dtpdatospaginas->pagid = 13;
            $dtpdatospaginas->fecid = $this->fecha();
            $dtpdatospaginas->dtpnombre = $nombreProducto;
            $dtpdatospaginas->dtpurl = $urlProducto;
            $dtpdatospaginas->dtpimagen = $imagenProducto;
            $dtpdatospaginas->dtpprecio = $precioProducto;
            $dtpdatospaginas->dtpcategoria = $tituloCategoria;
            $dtpdatospaginas->save(); 
        });
    }

    public function MetObtenerCentralMayorista()
    {
        $url = 'https://deadpool.instaleap.io/api/v2';
        $queryCategorias = array('operationName'=>'getStore','variables'=>['clientId'=>'CENTRAL_MAYORISTA'],'query'=>'query getStore($storeId: ID, $clientId: String) {  getStore(storeId: $storeId, clientId: $clientId) {    id    name    categories {      id      image      slug      name      redirectTo      isAvailableInHome      __typename    }    banners {      id      title      desktopImage      mobileImage      targetCategory      targetUrl {        url        type        __typename      }      __typename    }    __typename  }}');
        $queryCategoriasJson = json_encode($queryCategorias);
        $datosCategorias = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($queryCategoriasJson)
                            ->send();
        $store = $datosCategorias->body->data->getStore->id;
        $categorias = $datosCategorias->body->data->getStore->categories;    

        foreach ($categorias as $categoria) 
        {
            $id = $categoria->id;
            $tituloCategoria = $categoria->name;

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
                    $dtpdatospaginas = new dtpdatospaginas();
                    $dtpdatospaginas->pagid = 14;
                    $dtpdatospaginas->fecid = $this->fecha();
                    $dtpdatospaginas->dtpnombre = $producto->name;
                    $dtpdatospaginas->dtppagina = $pagina;
                    $dtpdatospaginas->dtpimagen = $producto->photosUrls[0];
                    $dtpdatospaginas->dtpprecio = $producto->price;
                    $dtpdatospaginas->dtpcategoria = $tituloCategoria;
                    $dtpdatospaginas->dtpsku = $producto->sku;
                    $dtpdatospaginas->dtpstock = $producto->stock;
                    $dtpdatospaginas->dtpdesclarga = $producto->description;
                    $dtpdatospaginas->save(); 
                }
            }
            
        }
    }

    public function MetObtenerCuponatic()
    {
        $categorias = array('panoramas','productos','viajes-y-turismo','belleza','servicios','gastronomia','bienestar-y-salud');
        foreach ($categorias as $categoria) {
            $urlCategoria = "https://cl-api.cuponatic-latam.com/api2/cdn/menu/seccion/$categoria?ciudad=Santiago";
            $datosCategoria = \Httpful\Request::get($urlCategoria)
                                    ->sendsJson()
                                    ->send();
            $subcategorias = $datosCategoria->body->hijos;
            foreach ($subcategorias as $subcategoria) {
                $slug = $subcategoria->slug;
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
                            $dtpdatospaginas = new dtpdatospaginas();
                            $dtpdatospaginas->pagid = 15;
                            $dtpdatospaginas->fecid = $this->fecha();
                            $dtpdatospaginas->dtpnombre = $productosSubcategoria->titulo;
                            $dtpdatospaginas->dtppagina = $numeroPaginas;
                            $dtpdatospaginas->dtpimagen = $productosSubcategoria->imagen;
                            $dtpdatospaginas->dtpprecio = $productosSubcategoria->valor_oferta;
                            $dtpdatospaginas->dtpcategoria = $slug;
                            $dtpdatospaginas->dtpurl = $productosSubcategoria->url_desktop;
                            $dtpdatospaginas->dtpstock = $productosSubcategoria->estado_venta;
                            $dtpdatospaginas->dtpmarca = $productosSubcategoria->marcas;
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
