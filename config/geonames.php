<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Geoames pagination limit
    |--------------------------------------------------------------------------
    |
    | The number of resources to return when paginating
    |
    */
    'pagination_limit' => env('GEONAMES_PAGINATION_LIMIT', 10),

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
    | Readme information file
    |--------------------------------------------------------------------------
    |
    | The .txt file containing all important information
    |
    */
    'readme_file' => env('GEONAMES_INFO_FILE', 'readme.txt'),

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
    | Language codes file
    |--------------------------------------------------------------------------
    |
    | The name of the file with all language codes
    |
    */
    'language_codes_file' => env('GEONAMES_LANGUAGE_CODES_FILE', 'iso-languagecodes.txt'),

    /*
    |--------------------------------------------------------------------------
    | Language codes file
    |--------------------------------------------------------------------------
    |
    | The name of the file with all language codes
    |
    */
    'feature_codes_file' => env('GEONAMES_FEATURE_CODES_FILE', 'featureCodes_en.txt'),

    /*
    |--------------------------------------------------------------------------
    | Time Zones file
    |--------------------------------------------------------------------------
    |
    | The name of the Time Zones file
    |
    */
    'time_zones_file' => env('GEONAMES_TIME_ZONES_FILE', 'timeZones.txt'),

    /*
    |--------------------------------------------------------------------------
    | Alternate Names file
    |--------------------------------------------------------------------------
    |
    | The name of the alternate names file
    |
    */
    'alternate_names_file' => env('GEONAMES_ALTERNATE_NAMES_FILE', 'alternateNamesV2.zip'),

    /*
    |--------------------------------------------------------------------------
    | Modifications file
    |--------------------------------------------------------------------------
    |
    | The name of the modifications file
    |
    */
    'modifications_file' => env('GEONAMES_MODIFICATIONS_FILE', 'modifications-<<date><.txt'),

    /*
    |--------------------------------------------------------------------------
    | Deletes file
    |--------------------------------------------------------------------------
    |
    | The name of the deletes file
    |
    */
    'deletes_file' => env('GEONAMES_DELETES_FILE', 'deletes-<<date>>.txt'),

    /*
    |--------------------------------------------------------------------------
    | Countries information file url
    |--------------------------------------------------------------------------
    |
    | The URL of the file containing all countries information
    |
    */
    'countries_url' => env('GEONAMES_COUNTRIES_URL', 'https://download.geonames.org/export/dump/countryInfo.txt'),

    /*
    |--------------------------------------------------------------------------
    | Language codes base url
    |--------------------------------------------------------------------------
    |
    | The URL of language codes
    |
    */
    'language_codes_url' => env('GEONAMES_LANGUAGE_CODES_URL', 'https://www.geonames.org/export/iso-languagecodes.txt'),

    /*
    |--------------------------------------------------------------------------
    | Readme file base url
    |--------------------------------------------------------------------------
    |
    | The URL of readme text file
    |
    */
    'readme_url' => env('GEONAMES_README_URL', 'https://download.geonames.org/export/dump/readme.txt'),

    /*
    |--------------------------------------------------------------------------
    | Feature Codes file base url
    |--------------------------------------------------------------------------
    |
    | The URL of feature codes file
    |
    */
    'feature_codes_url' => env('GEONAMES_FEATURE_CODES_URL', 'https://download.geonames.org/export/dump/featureCodes_en.txt'),

    /*
    |--------------------------------------------------------------------------
    | Time Zones file base url
    |--------------------------------------------------------------------------
    |
    | The URL of Time Zones file
    |
    */
    'time_zones_url' => env('GEONAMES_TIME_ZONES_URL', 'http://download.geonames.org/export/dump/timeZones.txt'),

    /*
    |--------------------------------------------------------------------------
    | Alternate Names file base url
    |--------------------------------------------------------------------------
    |
    | The URL of Alternate Names file
    |
    */
    'alternate_names_url' => env('GEONAMES_ALTERNATE_NAMES_URL', 'http://download.geonames.org/export/dump/alternateNamesV2.zip'),

    /*
    |--------------------------------------------------------------------------
    | Modifications file base url
    |--------------------------------------------------------------------------
    |
    | The URL of Modifications file
    |
    */
    'modifications_url' => env('GEONAMES_MODIFICATIONS_URL', 'http://download.geonames.org/export/dump/modifications.txt'),

    /*
    |--------------------------------------------------------------------------
    | Deletes file base url
    |--------------------------------------------------------------------------
    |
    | The URL of Deletes file
    |
    */
    'deletes_url' => env('GEONAMES_DELETES_URL', 'http://download.geonames.org/export/dump/deletes.txt'),
];
