<?php

namespace App\Imports;

use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\Continent;
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
        $this->iterable()
            ->chunk(500)
            ->each(function (LazyCollection $chunk) {
                $alternateNames = Collection::make();

                foreach ($chunk as $item) {
                    if (! isset($item[0], $item[1])) {
                        continue;
                    }

                    $id = $item[0];
                    $geonameId = $item[1];
                    $isoLanguage = $item[2] ?? null;

                    if (strlen($isoLanguage) !== 2) {
                        continue;
                    }

                    $language = Language::select('iso639_3')
                        ->whereNotNull('iso639_1')
                        ->where('iso639_1', $isoLanguage)
                        ->first();

                    if (! $language) {
                        continue;
                    }

                    $isPlace = Place::where('geoname_id', $geonameId)->exists();
                    $isContinent = Continent::where('geoname_id', $geonameId)->exists();

                    if (! $isContinent && ! $isPlace) {
                        continue;
                    }

                    $alternateNames->push([
                        'id' => $id,
                        'geoname_id' => $geonameId,
                        'language_code' => $language->iso639_3,
                        'name' => $item[3],
                        'is_preferred_name' => (bool) $item[4],
                        'is_short_name' => (bool) $item[5],
                        'is_colloquial' => (bool) $item[6],
                        'is_historic' => (bool) $item[7],
                    ]);
                }

                DB::transaction(function () use ($alternateNames) {
                    DB::table('alternate_names')
                        ->upsert($alternateNames->all(), [
                            'id',
                        ], [
                            'geoname_id',
                            'language_code',
                            'name',
                            'is_preferred_name',
                            'is_short_name',
                            'is_colloquial',
                            'is_historic',
                        ]);
                });
            });
    }
}
