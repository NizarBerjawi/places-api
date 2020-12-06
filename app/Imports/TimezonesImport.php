<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class TimezonesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $this->iterable()
            ->filter(function ($item) {
                return isset($item[17]);
            })
            ->unique(function ($item) {
                return $item[17];
            })
            ->chunk(1000)
            ->map(function (LazyCollection $chunk) {
                return $chunk->map(function (array $data) {
                    return [
                        'code' => $data[17],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                });
            })->each(function (LazyCollection $data) {
                DB::table('timezones')->insertOrIgnore($data->all());
            });
    }
}
