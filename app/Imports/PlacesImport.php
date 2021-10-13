<?php

namespace App\Imports;

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
            $this->fail(new \Exception("{$this->filepath} is not found."));
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
                            'latitude'   => $item[4],
                            'longitude'  => $item[5],
                            'geoname_id' => $item[0],
                        ]);
                    }

                    DB::table('places')->insert($places->all());
                    DB::table('locations')->insert($locations->all());
                });
        });
    }
}
