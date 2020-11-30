<?php

namespace App\Imports;

use App\Currency;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use Carbon\Carbon;

class CurrenciesImport extends CountriesFileIterator implements GeonamesImportable
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
            ->filter(function ($item) {
                return isset($item[10], $item[11]);
            })
            ->unique(function ($item) {
                return $item[10];
            })
            ->map(function (array $data) {
                return [
                    'code' => $data[10],
                    'name' => $data[11],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            });

        Currency::insert($data->all());
    }
}
