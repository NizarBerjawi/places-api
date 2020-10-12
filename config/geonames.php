<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Geoames files url
    |--------------------------------------------------------------------------
    |
    | The URL of the Geonames files dump
    |
    */
    'files_url' => env('GEONAMES_FILES_URL', 'https://download.geonames.org/export/dump'),

    /*
    |--------------------------------------------------------------------------
    | Country flags base url
    |--------------------------------------------------------------------------
    |
    | The URL of country flags
    |
    */
    'flags_url' => env('GEONAMES_FLAGS_URL', 'https://img.geonames.org/flags/x'),

    /*
    |--------------------------------------------------------------------------
    | Countries information file
    |--------------------------------------------------------------------------
    |
    | The .txt file containing all countries information
    |
    */
    'countries_file' => env('GEONAMES_COUNTRIES_FILE', 'countryInfo.txt'),

    /*
    |--------------------------------------------------------------------------
    | Feature codes page
    |--------------------------------------------------------------------------
    |
    | The page with all the Geonames feature codes
    |
    */
    'feature_codes_page' => env('GEONAMES_FEATURE_CODES_PAGE', 'codes.html'),

    /*
    |--------------------------------------------------------------------------
    | Language codes file
    |--------------------------------------------------------------------------
    |
    | The name of the file with all language codes
    |
    */
    'language_codes_file' => env('GEONAMES_LANGUAGE_CODES_FILE', 'iso-languagecodes.txt'),

    /*
    |--------------------------------------------------------------------------
    | Countries information file url
    |--------------------------------------------------------------------------
    |
    | The URL of the file containing all countries information
    |
    */
    'countries_url' => env('GEONAMES_COUNTRIES_URL', 'https://download.geonames.orgb/export/dump/countryInfo.txt'),

    /*
    |--------------------------------------------------------------------------
    | Feature codes base url
    |--------------------------------------------------------------------------
    |
    | The URL of feature codes page
    |
    */
    'feature_codes_url' => env('GEONAMES_FEATURE_CODES_URL', 'http://www.geonames.org/export/codes.html'),

    /*
    |--------------------------------------------------------------------------
    | Language codes base url
    |--------------------------------------------------------------------------
    |
    | The URL of language codes
    |
    */
    'language_codes_url' => env('GEONAMES_LANGUAGE_CODES_URL', 'http://www.geonames.org/export/iso-languagecodes.txt'),
];
