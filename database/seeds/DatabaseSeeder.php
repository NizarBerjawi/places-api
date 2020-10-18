<?php

use App\Country;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadCountryFlag;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\ImportCountriesFile;
use App\Jobs\ImportLanguagesFile;
use App\Jobs\LoadFeatureCodes;
use App\Jobs\LoadNeighbourCountries;
use App\Jobs\UnzipGeonamesFile;
use Illuminate\Database\Seeder;

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
        
        // 3- Download files related to every country
        $countries = Country::get();
        $countries->each(function (Country $country) {
            DownloadCountryFlag::dispatch($country);
            DownloadGeonamesFile::dispatch($country);
            UnzipGeonamesFile::dispatch($country);
        });

        // 4- Download the iso-languagecodes.txt file
        DownloadLanguages::dispatch();

        // 5- Load all neighbouring countries
        LoadNeighbourCountries::dispatch();
        
        // 6- Load all Feature classes and codes
        LoadFeatureCodes::dispatch();
        
        // 7- Import the iso-languagecodes.txt file
        ImportLanguagesFile::dispatch();
    }
}
