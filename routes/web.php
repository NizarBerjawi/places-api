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

$router->get('/', [
    'uses' => 'WebController@home',
    'as' => 'home',
]);

$router->get('/introduction', [
    'uses' => 'WebController@intro',
    'as' => 'intro',
]);

$router->get('/documentation', [
    'uses' => 'WebController@docs',
    'as' => 'docs',
]);

$router->get('/flags/{flag}', [
    'uses' => 'WebController@flags',
    'as' => 'flags',
]);

$router->get('/continents', [
    'uses' => 'WebController@continents',
    'as' => 'continents',
]);

$router->get('/countries', [
    'uses' => 'WebController@countries',
    'as' => 'countries',
]);

$router->get('/featureCodes', [
    'uses' => 'WebController@featureCodes',
    'as' => 'featureCodes',
]);

$router->get('/timeZones', [
    'uses' => 'WebController@timeZones',
    'as' => 'timeZones',
]);

$router->get('/languages', [
    'uses' => 'WebController@languages',
    'as' => 'languages',
]);

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function () use ($router) {
    $router->get('logs', [
        'uses' => 'LogViewerController@index',
        'as'   => 'logs',
        'middleware' => ['simple-auth'],
    ]);
});
