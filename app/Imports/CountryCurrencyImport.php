<?php

namespace App\Imports;

use App\Country;
use App\Currency;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CountryCurrencyImport extends CountriesFileIterator implements GeonamesImportable
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
            ->map(function (array $data) {
                $now = Carbon::now();

                $country = Country::query()
                    ->where('iso3166_alpha2', $data[0])
                    ->first();

                $currency = Currency::query()
                    ->where('code', $data[10])
                    ->first();

                return [
                    'country_id' => $country->id,
                    'currency_id' => $currency->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            });

        DB::table('country_currency')->insert($data->all());
    }
}
