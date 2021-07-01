<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
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
            $timeZones->push([
                // 'code'         => str_replace('/', '_', strtolower($item[1])),
                'time_zone'    => $item[1],
                'country_code' => $item[0],
                'gmt_offset'   => $item[2],
            ]);
        }

        DB::table('time_zones')->insert($timeZones->all());
    }
}
