<?php

namespace App\Imports;

use App\Imports\Iterators\CountriesFileIterator;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NeighbourCountriesImport extends CountriesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Decides whether to skip a row or not.
     *
     * @param array  $row
     * @param bool
     */
    public function skip(array $row)
    {
        return parent::skip($row) || Str::of($row[17])->trim()->isEmpty();
    }

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this
            ->iterable()
            ->reject([$this, 'skip'])
            ->flatMap(function (array $data) {
                $neighbourCodes = Str::of($data[17])->explode(',')->filter();

                return $neighbourCodes->map(function (string $code) use ($data) {
                    return [
                        'neighbour_code' => $code,
                        'country_code'   => $data[0],
                    ];
                });
            });

        DB::table('country_neighbour')
            ->upsert($data->all(), [
                'neighbour_code', 'country_code',
            ]);
    }
}
