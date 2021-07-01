<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

// use Illuminate\Support\Str;

class PlacesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $this->iterable()
            ->chunk(500)
            ->each(function (LazyCollection $chunk) {
                $places = Collection::make();
                $locations = Collection::make();

                foreach ($chunk as $item) {
                    $places->push([
                        'geoname_id'        => $item[0],
                        'name'              => $item[1],
                        'population'        => max((int) $item[14], 0),
                        'elevation'         => (int) $item[15],
                        'feature_code'      => $item[7] ?? null,
                        'country_code'      => $item[8] ?? null,
                        'time_zone'         => $item[17],
                    ]);

                    $locations->push([
                        'latitude'          => $item[4],
                        'longitude'         => $item[5],
                        'locationable_type' => \App\Models\Place::class,
                        'locationable_id'   => $item[0],
                    ]);
                }

                DB::table('places')->insert($places->all());
                DB::table('locations')->insert($locations->all());
            });
    }
}
