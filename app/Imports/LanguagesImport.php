<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Language;
use Carbon\Carbon;
use Illuminate\Support\LazyCollection;

class LanguagesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $this
            ->iterable()
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) {
                $languages = collect();

                foreach ($chunk as $item) {
                    $timestamp = Carbon::now()->toDateTimeString();

                    $language = [
                        'iso639_1' => $item[2],
                        'iso639_2' => $item[1],
                        'iso639_3' => $item[0],
                        'language_name' => $item[3],
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];

                    $languages->push($language);
                }

                Language::insert($languages->all());
            });
    }
}
