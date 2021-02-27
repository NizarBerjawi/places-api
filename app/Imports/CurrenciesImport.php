<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use App\Models\Currency;
use Carbon\Carbon;

class CurrenciesImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $currencies = collect();

        foreach ($this->iterable() as $item) {
            [$code, $name] = [$item[10], $item[11]];

            if (! isset($code, $name)) {
                continue;
            }

            $reject = $currencies->contains(
                function (array $currency) use ($code) {
                    return $currency['code'] === $code;
                }
            );

            if ($reject) {
                continue;
            }

            $timestamp = Carbon::now()->toDateTimeString();

            $currencies->push([
                'code'       => $code,
                'name'       => $name,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        Currency::insert($currencies->all());
    }
}
