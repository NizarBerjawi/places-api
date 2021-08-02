<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Flag;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FlagsImport implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $data = Country::query()
            ->get(['iso3166_alpha2'])
            ->map(function (Country $country) {
                $code = $country->iso3166_alpha2;

                return [
                    'path'         => 'storage/flags/'.$code.'/'.strtolower($code.'.gif'),
                    'country_code' => $code,
                ];
            });

        Flag::insert($data->all());
    }
}
