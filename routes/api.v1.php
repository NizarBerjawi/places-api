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

$router->group(['prefix' => 'countries'], function () use ($router) {
    $router->get('/', ['uses' => 'CountryController@index']);
    $router->get('/{countryCode}', ['uses' => 'CountryController@show']);

    $router->get('/{countryCode}/flag', ['uses' => 'CountryFlagController@index']);
    $router->get('/{countryCode}/currency', ['uses' => 'CountryCurrencyController@index']);
    $router->get('/{countryCode}/languages', ['uses' => 'CountryLanguageController@index']);
    $router->get('/{countryCode}/places', ['uses' => 'CountryPlaceController@index']);
    $router->get('/{countryCode}/timeZones', ['uses' => 'CountryTimeZoneController@index']);
    $router->get('/{countryCode}/neighbours', ['uses' => 'CountryNeighbourController@index']);
    $router->get('/{countryCode}/alternateNames', ['uses' => 'CountryAlternateNameController@index']);
});

$router->group(['prefix' => 'continents'], function () use ($router) {
    $router->get('/', ['uses' => 'ContinentController@index']);
    $router->get('/{continentCode}', ['uses' => 'ContinentController@show']);

    $router->get('/{continentCode}/countries', ['uses' => 'ContinentCountryController@index']);
    $router->get('/{continentCode}/alternateNames', ['uses' => 'ContinentAlternateNameController@index']);
});

$router->group(['prefix' => 'currencies'], function () use ($router) {
    $router->get('/', ['uses' => 'CurrencyController@index']);
    $router->get('/{currencyCode}', ['uses' => 'CurrencyController@show']);
});

$router->group(['prefix' => 'featureClasses'], function () use ($router) {
    $router->get('/', ['uses' => 'FeatureClassController@index']);
    $router->get('/{featureClassCode}', ['uses' => 'FeatureClassController@show']);
});

$router->group(['prefix' => 'featureCodes'], function () use ($router) {
    $router->get('/', ['uses' => 'FeatureCodeController@index']);
    $router->get('/{featureCodeCode}', ['uses' => 'FeatureCodeController@show']);
});

$router->group(['prefix' => 'timeZones'], function () use ($router) {
    $router->get('/', ['uses' => 'TimeZoneController@index']);
    $router->get('/{timeZoneCode}', ['uses' => 'TimeZoneController@show']);
});

$router->group(['prefix' => 'flags'], function () use ($router) {
    $router->get('/', ['uses' => 'FlagController@index']);
    $router->get('/{countryCode}', ['uses' => 'FlagController@show']);
});

$router->group(['prefix' => 'languages'], function () use ($router) {
    $router->get('/', ['uses' => 'LanguageController@index']);
    $router->get('/{languageCode}', ['uses' => 'LanguageController@show']);
});

$router->group(['prefix' => 'places'], function () use ($router) {
    $router->get('/', ['uses' => 'PlaceController@index']);
    $router->get('/{geonameId}', ['uses' => 'PlaceController@show']);

    $router->get('/{geonameId}/alternateNames', ['uses' => 'PlaceAlternateNameController@index']);
    $router->get('/{geonameId}/location', ['uses' => 'PlaceLocationController@index']);
});
