<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Models\Country;
use App\Models\Flag;
use Carbon\Carbon;

class FlagsImport implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $data = Country::query()
            ->get(['id', 'iso3166_alpha2'])
            ->map(function (Country $country) {
                $timestamp = Carbon::now()->toDateTimeString();
                $code = $country->iso3166_alpha2;

                return [
                    'path' => $code . '/' . strtolower($code . '.gif'),
                    'country_id' => $country->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            });

        Flag::insert($data->all());
    }
}
