<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/scrapingArcalauquen', 'ScraperController@arcalauquen');
$router->get('/scrapingTork', 'ScraperController@tork');
$router->get('/scrapingDipisa', 'ScraperController@dipisa');
$router->get('/scrapingAvalco', 'ScraperController@avalco');
$router->get('/scrapingDilen', 'ScraperController@dilen');
$router->get('/scrapingDpronto', 'ScraperController@dpronto');
$router->get('/scrapingSodimac', 'ScraperController@sodimac');
$router->get('/scrapingComcer', 'ScraperController@comcer');
$router->get('/scrapingOfimaster', 'ScraperController@ofimaster');
$router->get('/scrapingDaos', 'ScraperController@daos');
$router->get('/scrapingProvit', 'ScraperController@provit');
$router->get('/scrapingLimpiamas', 'ScraperController@limpiamas');
$router->get('/scrapingHygiene', 'ScraperController@hygiene');
$router->get('/scrapingMercado', 'ScraperController@mercado');
$router->get('/scrapingCuponatic', 'ScraperController@cuponatic');

$router->get('/obtener-data-arcalauquen', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerArcalauquen');
$router->get('/obtener-data-tork', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerTork');
$router->get('/obtener-data-dipisa', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerDipisa');
$router->get('/obtener-data-avalco', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerAvalco');
$router->get('/obtener-data-dilen', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerDilen');
$router->get('/obtener-data-sodimac', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerSodimac');
$router->get('/obtener-data-dpronto', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerDpronto');
$router->get('/obtener-data-comcer', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerComcer');
$router->get('/obtener-data-ofimaster', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerOfimaster');
$router->get('/obtener-data-daos', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerDaos');
$router->get('/obtener-data-provit', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerProvit');
$router->get('/obtener-data-limpiamas', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerLimpiamas');
$router->get('/obtener-data-hygiene', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerHygiene');
$router->get('/obtener-data-mayorista', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerCentralMayorista');
$router->get('/obtener-data-cuponatic', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerCuponatic');
$router->get('/alertas-paginas', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetAlertasPaginas');

$router->get('/exportar-competencias/{id}', 'Validaciones\ValExportarDatosController@ValExportarCompetencias');
$router->get('/exportar-usuarios/{id}', 'Validaciones\ValExportarDatosController@ValExportarUsuarios');
$router->get('/exportar-productos/{id}', 'Validaciones\ValExportarDatosController@ValExportarProductosEmpresa');
$router->get('/exportar-productos-no-homologados/{pagid}', 'Validaciones\ValExportarDatosController@ValExportarProductosNoHomologados');

$router->post('/obtener-marketplaces', 'Validaciones\MarketPlaces\ValObtenerMarketPlacesController@ValObtenerMarketPlaces');
$router->post('/obtener-marcas', 'Validaciones\Marcas\ValObtenerMarcasController@ValObtenerMarcas');
$router->post('/obtener-productos-homologados', 'Metodos\Competencia\ObtenerProductosController@ObtenerProductos');

//Homologaciones
$router->post('/obtener-compentencias', 'Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValObtenerListaCompetencias');
$router->post('/obtener-productos','Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValObtenerListaProducto');
$router->post('/asignar-sku','Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValAsignacionProductoCompetencia');
$router->post('/obtener-competencias','Metodos\Homologaciones\MetAsignarProductoDeCompetenciaController@MetObtenerCompetencias');


$router->post('/obtener-producto-seleccionado', 'Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValObtenerProductoConHomologaciones');

$router->post('/grafico-producto', 'Validaciones\Homologaciones\ValGraficoHomologacionesController@ValDatosProductoOriginalGrafico');
$router->post('/grafico-agregar-homologado', 'Validaciones\Homologaciones\ValGraficoHomologacionesController@ValObtenerProductosCompetenciaGrafico');
$router->get('/lista-comparador-competencia/{proid}', 'Validaciones\Homologaciones\ValProductosController@ValObtenerListaCompletaCompetencia');
$router->post('/productos-filtro', 'Validaciones\Homologaciones\ValProductosController@ValListarProductosFiltros');

$router->get('/obtener-permisos/{tpuid}','Validaciones\Administrativo\Permisos\ValPermisosController@ValObtenerListaPermisos');
$router->get('/obtener-archivos-cargados/{empid}','Validaciones\Upload\ValArchivosController@ValObtenerListaArchivosCargados');

$router->post('/crear-usuario', 'Validaciones\Administrativo\Usuarios\ValUsuariosController@ValCrearUsuario');
$router->patch('/editar-usuario/{usuid}', 'Validaciones\Administrativo\Usuarios\ValUsuariosController@ValEditarUsuario');
$router->delete('/eliminar-usuario/{usuid}', 'Validaciones\Administrativo\Usuarios\ValUsuariosController@ValEliminarUsuario');
$router->get('/obtener-usuarios/{empid}', 'Validaciones\Administrativo\Usuarios\ValUsuariosController@ValListarUsuarios');

$router->post('/crear-tipo-usuario', 'Validaciones\Administrativo\TiposUsuarios\ValTiposUsuariosController@ValCrearTipoUsuario');
$router->patch('/editar-tipo-usuario/{tpuid}', 'Validaciones\Administrativo\TiposUsuarios\ValTiposUsuariosController@ValEditarTipoUsuario');
$router->delete('/eliminar-tipo-usuario/{tpuid}', 'Validaciones\Administrativo\TiposUsuarios\ValTiposUsuariosController@ValEliminarTipoUsuario');
$router->get('/obtener-tipos-usuarios/{empid}', 'Validaciones\Administrativo\TiposUsuarios\ValTiposUsuariosController@ValListarTiposUsuarios');

$router->post('/login','Validaciones\Login\LoginController@ValLogin');
$router->post('/register','Validaciones\Login\LoginController@ValRegistrarUsuario');
$router->post('/enviar-correo','Validaciones\RecuperarContrasenia\RecuperarContraseniaController@ValEnviarCorreo');
$router->post('/cambiar-contrasenia','Validaciones\RecuperarContrasenia\RecuperarContraseniaController@ValCambiarContrasenia');

$router->post('/importar-excel-cliente','Validaciones\CargaArchivos\ValCargaArchivosController@ValImportarExcelCliente');
$router->post('/importar-excel-competencia','Validaciones\CargaArchivos\ValCargaArchivosController@ValImportarExcelCompetencia');
$router->post('/importar-excel-maestra-productos','Validaciones\CargaArchivos\ValCargaArchivosController@ValCargaMaestraProductos');
$router->post('/importar-excel-maestra-precios','Validaciones\CargaArchivos\ValCargaArchivosController@ValCargaMaestraPrecios');
$router->get('/precios/{fecha}','Metodos\CargaArchivos\MetCargaArchivosMaestraPreciosController@obtenerFechaExcel');

//Exportacion Archivos
$router->get('/generar-excel','Metodos\ExportacionArchivos\MetGenerarExcelController@MetExcelNorte');

$router->post('/crear-favorito','Validaciones\Favoritos\ValFavoritosController@ValCrearFavoritos');
$router->delete('/eliminar-favorito/{favid}','Validaciones\Favoritos\ValFavoritosController@ValEliminarFavoritos');

$router->get('/exportar-datospaginas-excel','Metodos\ExportacionArchivos\MetGenerarExcelDatosPaginasController@MetExportarExcelDtp');
$router->get('/obtener-link-excel-descargar-todo','Metodos\SalvacionController@Salvacion');
