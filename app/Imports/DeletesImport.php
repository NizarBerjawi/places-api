<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\Place;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class DeletesImport extends GeonamesFileIterator implements GeonamesImportable
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
                $ids = Collection::make();

                foreach ($chunk as $item) {
                    $ids->push($item[0]);
                }

                DB::table('places')
                    ->whereIn('geoname_id', $ids->all())
                    ->delete();

                DB::table('locations')
                    ->where('locationable_type', Place::class)
                    ->whereIn('locationable_id', $ids)
                    ->delete();
            });
    }
}
