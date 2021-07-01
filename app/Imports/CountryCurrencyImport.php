<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use Illuminate\Support\Facades\DB;

class CountryCurrencyImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $countryCurrencies = collect();

        foreach ($this->iterable() as $item) {
            if (! isset($item[10], $item[11])) {
                continue;
            }

            $countryCurrencies->push([
                'country_code'  => $item[0],
                'currency_code' => $item[10],
            ]);
        }

        DB::table('country_currency')->insert($countryCurrencies->all());
    }
}
