<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimeZonesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $timeZones = Collection::make();

        foreach ($this->iterable()->skip(1) as $item) {
            $timestamp = Carbon::now()->toDateTimeString();

            $timeZones->push([
                'code'         => str_replace('/', '-', strtolower($item[1])),
                'time_zone'    => $item[1],
                'country_code' => $item[0],
                'gmt_offset'   => $item[2],
                'created_at'   => $timestamp,
                'updated_at'   => $timestamp,
            ]);
        }

        DB::table('time_zones')->insert($timeZones->all());
    }
}
