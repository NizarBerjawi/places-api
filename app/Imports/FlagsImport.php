<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Models\Country;
use App\Models\Flag;
use Carbon\Carbon;

class FlagsImport implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $data = Country::query()
            ->get(['iso3166_alpha2'])
            ->map(function (Country $country) {
                $timestamp = Carbon::now()->toDateTimeString();
                $code = $country->iso3166_alpha2;

                return [
                    'path'         => 'storage/flags/'.$code.'/'.strtolower($code.'.gif'),
                    'country_code' => $code,
                    'created_at'   => $timestamp,
                    'updated_at'   => $timestamp,
                ];
            });

        Flag::insert($data->all());
    }
}
