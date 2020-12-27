<?php

namespace App\Imports;

use App\Country;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use App\Language;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountryLanguageImport extends CountriesFileIterator implements GeonamesImportable
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
            ->flatMap(function (array $row) {
                $languagesString = Str::of($row[15])->trim();

                if ($languagesString->isEmpty()) {
                    return collect();
                };

                $country = Country::query()
                    ->where('iso3166_alpha2', $row[0])
                    ->first();
                    
                return $languagesString
                    ->explode(',')
                    ->reject(function ($item) {
                        return empty($item);
                    })
                    ->unique()
                    ->map(function ($item) use ($country) {
                        $item = Str::of($item)->trim();

                        $languageCode = $item->explode('-')->first();

                        $language = Language::query()
                            ->where('iso639_1', $languageCode)
                            ->orWhere('iso639_2', $languageCode)
                            ->orWhere('iso639_3', $languageCode)
                            ->first();

                        if (! $language) {
                            return;
                        };

                        $timestamp = Carbon::now()->toDateTimeString();

                        return [
                            'country_id' => $country->id,
                            'language_id' => $language->id,
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp
                        ];
                    });
            });

        DB::table('country_language')->insert($data->all());
    }
}
