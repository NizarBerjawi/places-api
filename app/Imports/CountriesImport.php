<?php

namespace App\Imports;

use App\Continent;
use App\Country;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;

class CountriesImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $continents = Continent::get();

        $data = $this
            ->iterable()
            ->map(function (array $data) use ($continents) {
                $continent = $continents->where('code', $data[8])->first();

                return [
                    'name' => $data[4],
                    'iso3166_alpha2' => $data[0],
                    'iso3166_alpha3' => $data[1],
                    'iso3166_numeric' => $data[2],
                    'population' => $data[7],
                    'area' => $data[6],
                    'phone_code' => $data[12],
                    'continent_id' => $continent->id
                ];
            });

        Country::insert($data->all());
    }
}
