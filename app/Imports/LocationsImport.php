<?php

namespace App\Imports;

use App\Country;
use App\FeatureCode;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class LocationsImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $this->iterable()
            ->chunk(1000)
            ->map(function (LazyCollection $chunk) {
                return $chunk->map(function (array $data) {
                    $country = Country::where('iso3166_alpha2', $data[8])->first();
                    $featureCode = FeatureCode::where('code', $data[7])->first();
                    
                    return [
                        'name' => $data[1],
                        'population' => $data[14],
                        'elevation' => $data[15],
                        'feature_code_id' => $featureCode->id ?? null,
                        'country_id' => $country->id ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                });
            })->each(function (LazyCollection $data) {
                DB::table('places')->insert($data->all());
            });
    }
}
