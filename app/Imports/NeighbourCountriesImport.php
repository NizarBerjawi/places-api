<?php

namespace App\Imports;

use App\Country;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NeighbourCountriesImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Decides whether to skip a row or not
     *
     * @param array  $row
     * @param boolean
     */
    public function skip(array $row)
    {
        return parent::skip($row) || Str::of($row[17])->trim()->isEmpty();
    }

    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $data = $this
            ->iterable()
            ->flatMap(function ($data) {
                // Get the id of the country we are adding the neighbours for
                $country = Country::query()
                    ->select('id')
                    ->where('iso3166_alpha2', $data[0])
                    ->first();

                // Get the ids of all the neighbouring countries to be added
                $neighbourCodes = Str::of($data[17])->explode(',');
                $neighbours = Country::query()
                    ->select('id')
                    ->whereIn('iso3166_alpha2', $neighbourCodes)
                    ->get();

                return $neighbours->map(function (Country $neighbour) use ($country) {
                    $timestamp = Carbon::now()->toDateTimeString();

                    return [
                        'neighbour_id' => $neighbour->id,
                        'country_id' => $country->id,
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp
                    ];
                });
            });
            
        DB::table('country_neighbour')->insert($data->all());
    }
}
