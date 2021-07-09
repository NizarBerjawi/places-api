<?php

namespace Database\Seeders;

use App\Imports\PlacesImport;
use App\Jobs\DeleteGeonamesFile;
use App\Models\Country;
use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Country::cursor()
            ->each(function (Country $country) {
                $code = $country->iso3166_alpha2;

                $filepath = storage_path('app/data/'.$code.'/'.$code.'.txt');

                (new PlacesImport($filepath))->import();

                dispatch(new DeleteGeonamesFile($code));
            });
    }
}
