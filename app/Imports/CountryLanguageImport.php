<?php

namespace App\Imports;

use App\Imports\Iterators\CountriesFileIterator;
use App\Models\Language;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class CountryLanguageImport extends CountriesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $countryLanguages = Collection::make();

        foreach ($this->iterable() as $item) {
            $languagesString = Str::of($item[15])->trim();

            if ($languagesString->isEmpty()) {
                continue;
            }

            $languageCodes = $this->parseLanguageString($languagesString);
            $languages = Language::query()
                ->whereIn('iso639_1', $languageCodes)
                ->orWhereIn('iso639_2', $languageCodes)
                ->orWhereIn('iso639_3', $languageCodes)
                ->distinct()
                ->get('iso639_3');

            foreach ($languages as $language) {
                $countryLanguages->push([
                    'country_code' => $item[0],
                    'language_code' => $language->iso639_3,
                ]);
            }
        }

        DB::table('country_language')
            ->upsert($countryLanguages->all(), [
                'country_code',
                'language_code',
            ]);
    }

    /**
     * Parses a language string into an array of language codes.
     *
     * For example, the language string "am,en,en-ET,om-ET,ti-ET,so-ET,sid"
     * will turn to ["am", "en", "om", "ti", "so", "sid"]
     *
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
