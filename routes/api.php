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
    Route::get('/{code}', 'CountryController@show');

    Route::get('/{code}/flag', 'CountryFlagController@index');
    Route::get('/{code}/currency', 'CountryCurrencyController@index');
    Route::get('/{code}/languages', 'CountryLanguageController@index');
    Route::get('/{code}/places', 'CountryPlacesController@index');
    Route::get('/{code}/timeZones', 'CountryTimeZoneController@index');
});

Route::group(['prefix' => 'continents'], function () {
    Route::get('/', 'ContinentController@index');
    Route::get('/{code}', 'ContinentController@show');

    Route::get('/{code}/countries', 'ContinentCountryController@index');
});

Route::group(['prefix' => 'currencies'], function () {
    Route::get('/', 'CurrencyController@index');
    Route::get('/{code}', 'CurrencyController@show');
});

Route::group(['prefix' => 'featureClasses'], function () {
    Route::get('/', 'FeatureClassController@index');
    Route::get('/{code}', 'FeatureClassController@show');
});

Route::group(['prefix' => 'featureCodes'], function () {
    Route::get('/', 'FeatureCodeController@index');
    Route::get('/{code}', 'FeatureCodeController@show');
});

Route::group(['prefix' => 'timeZones'], function () {
    Route::get('/', 'TimeZoneController@index');
    Route::get('/{code}', 'TimeZoneController@show');
});

Route::group(['prefix' => 'flags'], function () {
    Route::get('/', 'FlagController@index');
    Route::get('/{code}', 'FlagController@show');
});

Route::group(['prefix' => 'languages'], function () {
    Route::get('/', 'LanguageController@index');
});
