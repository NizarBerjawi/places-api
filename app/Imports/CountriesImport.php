<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use App\Models\Continent;
use App\Models\Country;
use Carbon\Carbon;

class CountriesImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $countries = collect();
        $continents = Continent::query()
            ->select(['geoname_id', 'code'])
            ->get();

        foreach ($this->iterable() as $item) {
            $continent = $continents->firstWhere('code', $item[8]);

            if (! $continent) {
                continue;
            }

            $timestamp = Carbon::now()->toDateTimeString();
            $countries->push([
                'geoname_id' => $item[16],
                'name' => $item[4],
                'iso3166_alpha2' => $item[0],
                'iso3166_alpha3' => $item[1],
                'iso3166_numeric' => $item[2],
                'population' => $item[7],
                'area' => $item[6],
                'phone_code' => $item[12],
                'continent_id' => $continent->geoname_id,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);
        };

        Country::insert($countries->all());
    }
}
