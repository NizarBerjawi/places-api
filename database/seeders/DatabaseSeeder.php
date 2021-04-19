<?php

namespace Database\Seeders;

use App\Imports\Iterators\CountriesFileIterator;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadCountryFlag;
use App\Jobs\DownloadFeatureCodesFile;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadInfoFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\DownloadTimezonesFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // 1- Download readme.txt file
        // dispatch(new DownloadInfoFile());
        // // 2- Download the countryInfo.txt file
        // dispatch(new DownloadCountriesFile);
        // // 3- Download the iso-languagecodes.txt file
        // dispatch(new DownloadLanguages);
        // // 4- Download the featureCodes_en.txt file
        // dispatch(new DownloadFeatureCodesFile);
        // // 5- Download the timeZones.txt file
        // dispatch(new DownloadTimezonesFile);
        // // 6- Download Geonames files related to every country
        // $path = storage_path('app/'.config('geonames.countries_file'));
        // (new CountriesFileIterator($path))
        //     ->iterable()
        //     ->each(function (array $row) {
        //         $code = Arr::get($row, 0);
        //         dispatch(new DownloadCountryFlag($code));
        //         dispatch(new DownloadGeonamesFile($code));
        //     });

        // 7- Seed the continents table
        $this->call(ContinentsTableSeeder::class);
        // 8- Create all Currencies
        $this->call(CurrenciesTableSeeder::class);
        // 9- Parse and import the countryInfo.txt file
        $this->call(CountriesTableSeeder::class);
        // 10- Parse and import the timeZones.txt file
        $this->call(TimeZonesTableSeeder::class);
        // 11- Import the iso-languagecodes.txt file
        $this->call(LanguagesTableSeeder::class);
        // 12- Load all neighbouring countries
        $this->call(CountryNeighbourTableSeeder::class);
        // 13- Load all Feature classes and codes
        $this->call(FeatureClassesTableSeeder::class);
        $this->call(FeatureCodesTableSeeder::class);
        // 14- Load all Flags
        $this->call(FlagsTableSeeder::class);
        // 15- Create all Country-Language relations
        $this->call(CountryLanguageTableSeeder::class);
        // 16- Create all Country-Currency relations
        $this->call(CountryCurrencyTableSeeder::class);
        // 17- Create all Timezones
        $this->call(PlacesTableSeeder::class);
    }
}
