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

    const CHUNK_SIZE = 1000;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $this->iterable()
            ->chunk(self::CHUNK_SIZE)
            ->each(function (LazyCollection $chunk) {
                $geonameIds = Collection::make();
                $alternateNames = Collection::make();

                foreach ($chunk as $item) {
                    $id = $item[0];
                    $geonameId = $item[1];
                    $isoLanguage = $item[2] ?? null;

                    if (! isset($id, $geonameId)) {
                        continue;
                    }

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

                    $geonameIds->push($geonameId);

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

                // There is no data to insert in this batch, continue to the
                // next batch
                if ($geonameIds->isEmpty()) {
                    return true;
                }

                $unidentified = Place::getMissing($geonameIds->all());
                // We check if we have some Geoname IDs from the batch
                // that don't have a corresponding place entity in the database
                if ($unidentified->count() > 0) {
                    $maybeUnidentified = $unidentified->pluck('geoname_id');

                    // Check if some of the missing geoname IDs actually belong
                    // to continents
                    $certainlyUnidentified = Continent::getMissing($maybeUnidentified->all());

                    if ($certainlyUnidentified->count() > 0) {
                        $alternateNames = $alternateNames
                            ->whereNotIn('geoname_id', $certainlyUnidentified->pluck('geoname_id'));
                    }
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
