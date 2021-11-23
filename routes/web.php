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

$router->post('/login','Validaciones\Login\LoginController@ValLogin');

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

$router->get('/test', 'Metodos\ETL\MetEtlObtenerDatosPaginasController@MetObtenerArcalauquen');