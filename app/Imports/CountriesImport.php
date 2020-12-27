<?php

namespace App\Imports;

use App\Continent;
use App\Country;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
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
        $data = $this
            ->iterable()
            ->map(function (array $data) {
                $continent = Continent::where('code', $data[8])->first();
                $timestamp = Carbon::now()->toDateTimeString();

                return [
                    'name' => $data[4],
                    'iso3166_alpha2' => $data[0],
                    'iso3166_alpha3' => $data[1],
                    'iso3166_numeric' => $data[2],
                    'population' => $data[7],
                    'area' => $data[6],
                    'phone_code' => $data[12],
                    'continent_id' => $continent->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
            });

        Country::insert($data->all());
    }
}
