<?php

use App\Imports\Iterators\CountriesFileIterator;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadCountryFlag;
use App\Jobs\DownloadFeatureCodesFile;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadInfoFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\DownloadTimezonesFile;
use App\Jobs\UnzipGeonamesFile;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\FilesystemAdapter;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(FilesystemAdapter $disk)
    {
        // 1- Download readme file
        DownloadInfoFile::dispatch();
        // 2- Download the countryInfo.txt file
        DownloadCountriesFile::dispatch();
        // 3- Download Files related to every country
        $path = $disk->path(config('geonames.countries_file'));
        (new CountriesFileIterator($path))
            ->iterable()
            ->each(function (array $row) {
                DownloadCountryFlag::dispatch($row[0]);
                DownloadGeonamesFile::dispatch($row[0]);
                UnzipGeonamesFile::dispatch($row[0]);
            });

        // 4- Download the iso-languagecodes.txt file
        DownloadLanguages::dispatch();
        // 5- Download the featureCodes_en.txt file
        DownloadFeatureCodesFile::dispatch();
        DownloadTimezonesFile::dispatch();
        // 6- Seed the continents table
        $this->call(ContinentsTableSeeder::class);
        // 13- Create all Currencies
        $this->call(CurrenciesTableSeeder::class);
        // 7- Parse and import the countryInfo.txt file
        $this->call(CountriesTableSeeder::class);
        //
        $this->call(TimeZonesTableSeeder::class);
        // 8- Import the iso-languagecodes.txt file
        $this->call(LanguagesTableSeeder::class);
        // 9- Load all neighbouring countries
        $this->call(CountryNeighbourTableSeeder::class);
        // 10- Load all Feature classes and codes
        $this->call(FeatureClassesTableSeeder::class);
        $this->call(FeatureCodesTableSeeder::class);
        // 11- Load all Flags
        $this->call(FlagsTableSeeder::class);
        // 12- Create all Country-Language relations
        $this->call(CountryLanguageTableSeeder::class);
        $this->call(CountryCurrencyTableSeeder::class);
        // 15- Create all Timezones
        $this->call(PlacesTableSeeder::class);
    }
}
