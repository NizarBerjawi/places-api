<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\Country;
use App\Models\TimeZone;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CountryTimeZoneImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $countryTimeZones = collect();

        $country = new Country();
        foreach ($this->iterable()->skip(1) as $item) {
            $timestamp = Carbon::now()->toDateTimeString();

            if ($country && $country->iso3166_alpha2 !== $item[0]) {
                $country = $country->where('iso3166_alpha2', $item[0])->first();
            }

            $timeZone = TimeZone::where('code', $item[1])->first();

            $countryTimeZones->push([
                'country_code'   => $country->iso3166_alpha2,
                'time_zone_code' => $timeZone->code,
                'created_at'     => $timestamp,
                'updated_at'     => $timestamp,
            ]);
        }

        DB::table('country_time_zone')->insert($countryTimeZones->all());
    }
}
