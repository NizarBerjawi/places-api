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
    'url' => env('GEONAMES_COUNTRY_FILES', 'https://download.geonames.org/export/dump'),

    /*
    |--------------------------------------------------------------------------
    | Country flags base url
    |--------------------------------------------------------------------------
    |
    | The URL of country flags
    |
    */
    'flags' => env('GEONAMES_FLAGS', 'https://img.geonames.org/flags/x'),

    /*
    |--------------------------------------------------------------------------
    | Feature codes base url
    |--------------------------------------------------------------------------
    |
    | The URL of feature codes
    |
    */
    'feature_codes' => env('GEONAMES_FEATURE_CODES', 'http://www.geonames.org/export/codes.html'),

    /*
    |--------------------------------------------------------------------------
    | Language codes base url
    |--------------------------------------------------------------------------
    |
    | The URL of language codes
    |
    */
    'language_codes' => env('GEONAMES_LANGUAGE_CODES', 'http://www.geonames.org/export/iso-languagecodes.txt'),
];