<?php

namespace App\Imports;

use App\Imports\Iterators\CountriesFileIterator;
use App\Models\Continent;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CountriesImport extends CountriesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $countries = Collection::make();
        $continents = Continent::query()
            ->select(['code'])
            ->get();

        foreach ($this->iterable() as $item) {
            $continent = $continents->firstWhere('code', $item[8]);

            if (! $continent) {
                continue;
            }

            $countries->push([
                'geoname_id' => $item[16],
                'name' => $item[4],
                'iso3166_alpha2' => $item[0],
                'iso3166_alpha3' => $item[1],
                'iso3166_numeric' => $item[2],
                'fips' => $item[3],
                'topLevelDomain' => $item[9],
                'population' => $item[7],
                'area' => $item[6],
                'phone_code' => $item[12],
                'continent_code' => $continent->code,
            ]);
        }

        DB::table('countries')
            ->upsert($countries->all(), [
                'geoname_id',
            ]);
    }
}
