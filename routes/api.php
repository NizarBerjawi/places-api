<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'countries'], function () {
    Route::get('/', 'CountryController@index');
    Route::get('/{country}', 'CountryController@show');

    Route::get('/{country}/flag', 'CountryFlagController@index');
    Route::get('/{country}/currency', 'CountryCurrencyController@index');
    Route::get('/{country}/languages', 'CountryLanguageController@index');
    Route::get('/{country}/places', 'CountryPlacesController@index');
});

Route::group(['prefix' => 'continents'], function () {
    Route::get('/', 'ContinentController@index');
    Route::get('/{continent}', 'ContinentController@show');

    Route::get('/{continent}/countries', 'ContinentCountryController@index');
});

Route::group(['prefix' => 'currencies'], function () {
    Route::get('/', 'CurrencyController@index');
    Route::get('/{currency}', 'CurrenciesController@show');
});

Route::group(['prefix' => 'featureClasses'], function () {
    Route::get('/', 'FeatureClassController@index');
    Route::get('/{featureClass}', 'FeatureClassController@show');
});

Route::group(['prefix' => 'featureCodes'], function () {
    Route::get('/', 'FeatureCodeController@index');
    Route::get('/{featureCode}', 'FeatureCodeController@show');
});

Route::group(['prefix' => 'timeZones'], function () {
    Route::get('/', 'TimeZoneController@index');
    Route::get('/{timeZone}', 'TimeZoneController@show');
});

Route::group(['prefix' => 'flags'], function () {
    Route::get('/', 'FlagController@index');
    Route::get('/{flag}', 'FlagController@show');
});

Route::group(['prefix' => 'languages'], function () {
    Route::get('/', 'LanguageController@index');
});
