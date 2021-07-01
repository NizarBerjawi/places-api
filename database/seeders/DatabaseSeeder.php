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
