<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Geoames base url
    |--------------------------------------------------------------------------
    |
    | The URL of Geoname service
    |
    */
    'url' => env('GEONAMES_URL', 'https://download.geonames.org/export/dump'),

    /*
    |--------------------------------------------------------------------------
    | Country flags base url
    |--------------------------------------------------------------------------
    |
    | The URL of country flags
    |
    */
    'flags' => env('FLAGS_API_URL', 'https://img.geonames.org/flags/x'),

    /*
    |--------------------------------------------------------------------------
    | Feature codes base url
    |--------------------------------------------------------------------------
    |
    | The URL of feature codes
    |
    */
    'feature_codes' => env('FEATURE_CODE_URL', 'http://www.geonames.org/export/codes.html'),

];