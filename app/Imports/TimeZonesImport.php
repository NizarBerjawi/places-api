<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimeZonesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $timeZones = collect();

        foreach ($this->iterable()->skip(1) as $item) {
            $timestamp = Carbon::now();
            
            $timeZones->push([
                'code' => $item[1],
                'gmt_offset' => $item[2],
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);
        }

        DB::table('time_zones')->insert($timeZones->all());
    }
}
