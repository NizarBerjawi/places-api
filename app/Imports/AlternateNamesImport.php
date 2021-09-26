<?php

namespace App\Imports;

use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\Language;
use App\Models\Place;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class AlternateNamesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $languages = Language::query()
            ->whereNotNull('iso639_1')
            ->get();

        $this->iterable()
            ->chunk(500)
            ->each(function (LazyCollection $chunk) use ($languages) {
                $alternateNames = Collection::make();

                foreach ($chunk as $item) {
                    $isoLanguage = $item[2] ?? null;

                    if (strlen($isoLanguage) !== 2) {
                        continue;
                    }

                    if (empty($item[1])) {
                        continue;
                    }

                    $language = $languages
                        ->where('iso639_1', $isoLanguage)
                        ->first();

                    if (! $language) {
                        continue;
                    }

                    if (Place::where('geoname_id', $item[1])->doesntExist()) {
                        continue;
                    }

                    $alternateNames->push([
                        'geoname_id' => $item[1],
                        'language_id' => $language->id,
                        'name' => $item[3],
                        'is_preferred_name' => (bool) $item[4],
                        'is_short_name' => (bool) $item[5],
                    ]);
                }

                DB::transaction(function () use ($alternateNames) {
                    DB::table('alternate_names')->insertOrIgnore($alternateNames->all());
                });
            });
    }
}
