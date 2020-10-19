<?php

namespace App\Imports;

use App\Country;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class CountriesImport implements ToModel
{
    /**
     * Dissolved countries that don't exist any more.
     *
     * @var array
     */
    public $excluded = ['CS', 'AN'];

    /**
     * @param array $row
     *
     * @return Country|null
     */
    public function model(array $row)
    {
        if (Str::startsWith($row[0], '#')) {
            return;
        }

        if (in_array($row[0], $this->excluded)) {
            return;
        }

        return new Country([
            'name' => $row[4],
            'iso3166_alpha2' => $row[0],
            'iso3166_alpha3' => $row[1],
            'iso3166_numeric' => $row[2],
            'population' => $row[7],
            'area' => $row[6],
            'phone_code' => $row[12],
        ]);
    }
}
