<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\ImportCountriesFile;

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
            //
        });


    }
}
