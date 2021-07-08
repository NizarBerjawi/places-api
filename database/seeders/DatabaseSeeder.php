<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1- Seed the continents table
        $this->call(ContinentsTableSeeder::class);
        // 2- Create all Currencies
        $this->call(CurrenciesTableSeeder::class);
        // 3- Parse and import the countryInfo.txt file
        $this->call(CountriesTableSeeder::class);
        // 4- Parse and import the timeZones.txt file
        $this->call(TimeZonesTableSeeder::class);
        // 5- Import the iso-languagecodes.txt file
        $this->call(LanguagesTableSeeder::class);
        // 6- Load all neighbouring countries
        $this->call(CountryNeighbourTableSeeder::class);
        // 7- Load all Feature classes and codes
        $this->call(FeatureClassesTableSeeder::class);
        $this->call(FeatureCodesTableSeeder::class);
        // 8- Load all Flags
        $this->call(FlagsTableSeeder::class);
        // 9- Create all Country-Language relations
        $this->call(CountryLanguageTableSeeder::class);
        // 10- Create all Country-Currency relations
        $this->call(CountryCurrencyTableSeeder::class);
        // 11- Create all Timezones
        $this->call(PlacesTableSeeder::class);
    }
}
