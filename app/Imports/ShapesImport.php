<?php

namespace App\Imports;

use App\Exceptions\ImportFailedException;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\Country;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ShapesImport extends GeonamesFileIterator implements ShouldQueue
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
            $shapes = Collection::make();

            foreach ($this->iterable() as $index => $row) {
                if ($index === 0) {
                    continue;
                }

                $country = Country::where('geoname_id', $row[0])->first();

                if (! $country) {
                    continue;
                }

                $shapes->push([
                    'country_code' => $country->iso3166_alpha2,
                    'geometry' => $row[1],
                ]);
            }

            DB::table('places_shapes')
                ->upsert($shapes->all(), [
                    'country_code',
                ], [
                    'country_code',
                    'geometry',
                ]);
        });
    }
}
