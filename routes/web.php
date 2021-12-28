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

$router->get('/test', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerHygiene');

$router->get('/exportar-competencias/{id}', 'Validaciones\ValExportarDatosController@ValExportarCompetencias');
$router->get('/exportar-usuarios/{id}', 'Validaciones\ValExportarDatosController@ValExportarUsuarios');
$router->get('/exportar-productos/{id}', 'Validaciones\ValExportarDatosController@ValExportarProductosNoHomologados');

$router->get('/obtener-compentencias/{pagid}', 'Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValObtenerListaCompetencias');
$router->get('/obtener-productos/{empid}','Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValObtenerListaProducto');
$router->patch('/asignar-sku/{dtpid}/{proid}','Validaciones\Homologaciones\ValAsignarProductoDeCompetenciaController@ValAsignacionProductoCompetencia');

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
$router->get('/descargar-fichero-competencia/{nombre_fichero}','Metodos\CargaArchivos\MetCargaArchivosMLCompetenciaController@MetDescargarArchivo');

$router->post('/crear-favorito','Validaciones\Favoritos\ValFavoritosController@ValCrearFavoritos');
$router->delete('/eliminar-favorito/{favid}','Validaciones\Favoritos\ValFavoritosController@ValEliminarFavoritos');