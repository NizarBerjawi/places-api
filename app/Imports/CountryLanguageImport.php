<?php

namespace App\Imports;

use App\Country;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use App\Language;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class CountryLanguageImport extends CountriesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $countryLanguages = collect();

        foreach ($this->iterable() as $item) {
            $languagesString = Str::of($item[15])->trim();

            if ($languagesString->isEmpty()) {
                continue;
            };

            $languageCodes = $this->parseLanguageString($languagesString);
            $languages = Language::query()
                ->whereIn('iso639_1', $languageCodes)
                ->orWhereIn('iso639_2', $languageCodes)
                ->orWhereIn('iso639_3', $languageCodes)
                ->distinct()
                ->get('id');

            $country = Country::query()
                ->where('iso3166_alpha2', $item[0])
                ->first();

            foreach ($languages as $language) {
                $timestamp = Carbon::now()->toDateTimeString();

                $countryLanguages->push([
                    'country_id' => $country->id,
                    'language_id' => $language->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }

        DB::table('country_language')->insert($countryLanguages->all());
    }

    /**
     * Parses a language string into an array of language codes.
     *
     * For example, the language string "am,en,en-ET,om-ET,ti-ET,so-ET,sid"
     * will turn to ["am", "en", "om", "ti", "so", "sid"]
     *
     * @param \Illuminate\Support\Stringable  $languagesString
     * @return \Illuminate\Support\Collection
     */
    private function parseLanguageString(Stringable $languagesString)
    {
        return $languagesString
            ->explode(',')
            ->map(function (string $language) {
                return Str::of($language)
                    ->trim()
                    ->explode('-')
                    ->first();
            })
            ->filter()
            ->unique();
    }
}
