<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimezonesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $data = collect([]);

        foreach ($this->iterable() as $key => $item) {
            $now = Carbon::now()->toDateTimeString();
            
            if (! isset($item[17])) {
                continue;
            }

            $timezone = [
                'code' => $item[17],
                'created_at' => $now,
                'updated_at' => $now
            ];

            $shouldAdd = ! $data->contains(function ($item) use ($timezone) {
                return $item['code'] === $timezone['code'];
            });

            if ($shouldAdd) {
                $data->push($timezone);
            }
        };

        DB::table('timezones')->insertOrIgnore($data->all());
    }
}
