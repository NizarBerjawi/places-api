<?php

use App\Http\Controllers\Api\V1\ContinentAlternateNameController;
use App\Http\Controllers\Api\V1\ContinentController;
use App\Http\Controllers\Api\V1\ContinentCountryController;
use App\Http\Controllers\Api\V1\ContinentGeometryController;
use App\Http\Controllers\Api\V1\CountryAlternateNameController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\CountryCurrencyController;
use App\Http\Controllers\Api\V1\CountryFlagController;
use App\Http\Controllers\Api\V1\CountryGeometryController;
use App\Http\Controllers\Api\V1\CountryLanguageController;
use App\Http\Controllers\Api\V1\CountryNeighbourController;
use App\Http\Controllers\Api\V1\CountryPlaceController;
use App\Http\Controllers\Api\V1\CountryTimeZoneController;
use App\Http\Controllers\Api\V1\CurrencyController;
use App\Http\Controllers\Api\V1\FeatureClassController;
use App\Http\Controllers\Api\V1\FeatureCodeController;
use App\Http\Controllers\Api\V1\FlagController;
use App\Http\Controllers\Api\V1\LanguageController;
use App\Http\Controllers\Api\V1\PlaceAlternateNameController;
use App\Http\Controllers\Api\V1\PlaceController;
use App\Http\Controllers\Api\V1\PlaceLocationController;
use App\Http\Controllers\Api\V1\StatisticsController;
use App\Http\Controllers\Api\V1\TimeZoneController;
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
Route::prefix('countries')->group(function () {
    Route::get('/', [CountryController::class, 'index']);
    Route::get('/{countryCode}', [CountryController::class, 'show']);

    Route::get('/{countryCode}/flag', [CountryFlagController::class, 'index']);
    Route::get('/{countryCode}/currency', [CountryCurrencyController::class, 'index']);
    Route::get('/{countryCode}/languages', [CountryLanguageController::class, 'index']);
    Route::get('/{countryCode}/places', [CountryPlaceController::class, 'index']);
    Route::get('/{countryCode}/timeZones', [CountryTimeZoneController::class, 'index']);
    Route::get('/{countryCode}/neighbours', [CountryNeighbourController::class, 'index']);
    Route::get('/{countryCode}/alternateNames', [CountryAlternateNameController::class, 'index']);
    Route::get('/{countryCode}/geometry', [CountryGeometryController::class, 'index']);
});

Route::prefix('continents')->group(function () {
    Route::get('/', [ContinentController::class, 'index']);
    Route::get('/{continentCode}', [ContinentController::class, 'show']);

    Route::get('/{continentCode}/countries', [ContinentCountryController::class, 'index']);
    Route::get('/{continentCode}/alternateNames', [ContinentAlternateNameController::class, 'index']);
    Route::get('/{continentCode}/geometry', [ContinentGeometryController::class, 'index']);
});

Route::prefix('currencies')->group(function () {
    Route::get('/', [CurrencyController::class, 'index']);
    Route::get('/{currencyCode}', [CurrencyController::class, 'show']);
});

Route::prefix('featureClasses')->group(function () {
    Route::get('/', [FeatureClassController::class, 'index']);
    Route::get('/{featureClassCode}', [FeatureClassController::class, 'show']);
});

Route::prefix('featureCodes')->group(function () {
    Route::get('/', [FeatureCodeController::class, 'index']);
    Route::get('/{featureCodeCode}', [FeatureCodeController::class, 'show']);
});

Route::prefix('timeZones')->group(function () {
    Route::get('/', [TimeZoneController::class, 'index']);
    Route::get('/{timeZoneCode}', [TimeZoneController::class, 'show']);
});

Route::prefix('flags')->group(function () {
    Route::get('/', [FlagController::class, 'index']);
    Route::get('/{countryCode}', [FlagController::class, 'show']);
});

Route::prefix('languages')->group(function () {
    Route::get('/', [LanguageController::class, 'index']);
    Route::get('/{languageCode}', [LanguageController::class, 'show']);
});

Route::prefix('places')->group(function () {
    Route::get('/', [PlaceController::class, 'index']);
    Route::get('/{geonameId}', [PlaceController::class, 'show']);

    Route::get('/{geonameId}/alternateNames', [PlaceAlternateNameController::class, 'index']);
    Route::get('/{geonameId}/location', [PlaceLocationController::class, 'index']);
});

Route::prefix('statistics')->group(function () {
    Route::get('/', [StatisticsController::class, 'index']);
});
