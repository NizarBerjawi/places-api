<?php

namespace App\Imports;

use App\Country;
use App\FeatureCode;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Location;
use App\Place;
use Carbon\Carbon;
use Illuminate\Support\LazyCollection;

class PlacesImport extends GeonamesFileIterator implements GeonamesImportable
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
                // We start collecting Place and Location data
                // from the country geoname file and database
                return $chunk->map(function (array $data, $key) {
                    $country = Country::query()
                        ->where('iso3166_alpha2', $data[8])
                        ->first();

                    $featureCode = FeatureCode::query()
                        ->where('code', $data[7])
                        ->first();

                    $now = Carbon::now();

                    return [
                        'place' => [
                            'name' => $data[1],
                            'population' => $data[14],
                            'elevation' => $data[15],
                            'feature_code_id' => $featureCode->id ?? null,
                            'country_id' => $country->id ?? null,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                        'location' => [
                            'latitude' => $data[4],
                            'longitude' => $data[5],
                            'locationable_type' => Place::class,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]
                    ];
                });
            })->each(function (LazyCollection $data, $key) {
                $locations = collect();
                $places = collect();

                foreach ($data as $item) {
                    $locations->push($item['location']);
                    $places->push($item['place']);
                }

                Place::insert($places->all());

                $total = Place::count();
                $batchCount = $data->count();

                // We get all the Places that where just inserted in
                // this batch
                $places = Place::query()
                    ->skip($total - $batchCount)
                    ->limit($batchCount)
                    ->orderBy('id')
                    ->get();

                // We prepare the Location data for the current batch
                // of places that was inserted in the database
                $data = $locations->map(function ($location, $key) use ($places) {
                    return array_merge($location, [
                        'locationable_id' => $places->get($key)->id
                    ]);
                });

                Location::insert($data->all());
            });
    }
}
