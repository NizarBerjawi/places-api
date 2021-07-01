<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Models\Country;
use App\Models\Flag;

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
                $code = $country->iso3166_alpha2;

                return [
                    'path'         => 'storage/flags/'.$code.'/'.strtolower($code.'.gif'),
                    'country_code' => $code,
                ];
            });

        Flag::insert($data->all());
    }
}
