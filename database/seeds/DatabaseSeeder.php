<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\ImportCountriesFile;
use App\Jobs\ImportLanguagesFile;
use App\Jobs\LoadFeatureCodes;
use App\Jobs\LoadFeatures;
use App\Jobs\UnzipGeonamesFile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1- Download the countryInfo.txt file
        DownloadCountriesFile::dispatch();
        
        // 2- Parse and import the countryInfo.txt file
        ImportCountriesFile::dispatch();
        
        // 3- Download the geonames files for every country
        $countries = Country::get();
        $countries->each(function(Country $country) {
            DownloadGeonamesFile::dispatch($country);
            UnzipGeonamesFile::dispatch($country);
        });

        // 4- Load all Feature classes and codes
        LoadFeatureCodes::dispatch();

        // 5- Download the iso-languagecodes.txt file
        DownloadLanguages::dispatch();
        
        // 6- Import the iso-languagecodes.txt file
        ImportLanguagesFile::dispatch();
    }
}
