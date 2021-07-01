<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use App\Models\Currency;
use Illuminate\Support\Collection;

class CurrenciesImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $currencies = Collection::make();

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

            $currencies->push([
                'code'       => $code,
                'name'       => $name,
            ]);
        }

        Currency::insert($currencies->all());
    }
}
