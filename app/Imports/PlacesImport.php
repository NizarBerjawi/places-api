<?php

namespace App\Imports;

use App\Exceptions\ImportFailedException;
use App\Imports\Iterators\GeonamesFileIterator;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class PlacesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->isMissing()) {
            $this->fail(
                new ImportFailedException("{$this->filepath} could not be imported.")
            );
        }

        DB::transaction(function () {
            $this->iterable()
                ->chunk(500)
                ->each(function (LazyCollection $chunk) {
                    $places = Collection::make();
                    $locations = Collection::make();

                    foreach ($chunk as $item) {
                        $places->push([
                            'geoname_id'     => $item[0],
                            'name'           => $item[1],
                            'ascii_name'     => $item[2],
                            'population'     => max((int) $item[14], 0),
                            'elevation'      => (int) $item[15],
                            'dem'            => (int) $item[16],
                            'feature_code'   => $item[7] ?? null,
                            'country_code'   => $item[8] ?? null,
                            'time_zone_code' => $item[17] ? str_replace('/', '_', strtolower($item[17])) : null,
                        ]);

                        $locations->push([
                            'geoname_id' => $item[0],
                            'latitude'   => $item[4],
                            'longitude'  => $item[5],
                        ]);
                    }

                    DB::table('places')
                        ->upsert($places->all(), [
                            'geoname_id',
                        ], [
                            'geoname_id',
                            'name',
                            'ascii_name',
                            'population',
                            'elevation',
                            'dem',
                            'feature_code',
                            'country_code',
                            'time_zone_code',
                        ]);

                    DB::table('locations')
                        ->upsert($locations->all(), [
                            'geoname_id',
                        ], [
                            'geoname_id',
                            'latitude',
                            'longitude',
                        ]);
                });
        });
    }
}
