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

class TimeZonesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
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
