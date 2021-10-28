<?php

namespace App\Imports;

use App\Imports\Iterators\CountriesFileIterator;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FlagsImport extends CountriesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $flags = Collection::make();

        foreach ($this->iterable() as $item) {
            $code = $item[0];

            $flags->push([
                'country_code' => $code,
                'filename'     => $code.'.gif',
                'filepath'     => 'app/flags',
            ]);
        }

        DB::table('flags')->upsert($flags->all(), [
            'country_code',
        ]);
    }
}
