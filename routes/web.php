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

$router->get('/test', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerDpronto');
$router->get('/exportar-competencias/{id}', 'Metodos\MetExportarDatosController@exportarCompetencias');
$router->get('/exportar-usuarios/{id}', 'Metodos\MetExportarDatosController@exportarUsuarios');
$router->get('/exportar-productos/{id}', 'Metodos\MetExportarDatosController@exportarProductosNoHomologados');
$router->get('/obtener-compentencias/{pagid}', 'Metodos\Homologaciones\MetAsignarProductoDeCompetenciaController@MetObtenerListaCompetencias');
$router->get('/obtener-productos/{empid}','Metodos\Homologaciones\MetAsignarProductoDeCompetenciaController@MetObtenerListaProducto');
$router->patch('/asignar-sku/{dtpid}/{sku}','Metodos\Homologaciones\MetAsignarProductoDeCompetenciaController@MetAsignacionProductoCompetencia');

$router->get('/obtener-tipos-usuarios/{empid}','Metodos\Administrativo\MetUsuariosController@MetObtenerListaTiposUsuarios');
$router->get('/obtener-usuarios/{empid}','Metodos\Administrativo\MetUsuariosController@MetObtenerListaUsuarios');
$router->get('/obtener-permisos/{tpuid}','Metodos\Administrativo\MetUsuariosController@MetObtenerListaPermisos');
$router->get('/obtener-archivos-cargados/{empid}','Metodos\Upload\MetArchivosController@MetObtenerListaArchivosCargados');

$router->post('/crear-usuario', 'Validaciones\Administrativo\Usuarios\ValUsuariosController@ValCrearUsuario');

$router->post('/login','Validaciones\Login\LoginController@ValLogin');
$router->post('/register','Validaciones\Login\LoginController@ValRegistrarUsuario');
$router->post('/enviar-correo','Validaciones\RecuperarContrasenia\RecuperarContraseniaController@ValEnviarCorreo');
$router->post('/cambiar-contrasenia','Validaciones\RecuperarContrasenia\RecuperarContraseniaController@ValCambiarContrasenia');

