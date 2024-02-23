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
$router->group(['prefix' => 'api'], function ($router) {
    $router->get('/get-token-mws', 'AuthController@get_token_mws');
    $router->get('/get-token-sso', 'AuthController@get_token_sso');
    $router->get('/get-data-pns-by-nip/{nip}', 'PegawaiController@find_pns_by_nip');
});
