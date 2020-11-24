<?php

namespace App\Imports;

use App\Country;
use App\Flag;
use App\Imports\Concerns\GeonamesImportable;

class FlagsImport implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $data = Country::get()
            ->map(function (Country $country) {
                $code = $country->iso3166_alpha2;

                return [
                    'path' => $code . '/' . strtolower($code . '.gif'),
                    'country_id' => $country->id
                ];
            });

        Flag::insert($data->all());
    }
}
