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
use Illuminate\Support\LazyCollection;

class LanguagesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $this
            ->iterable()
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) {
                $languages = Collection::make();

                foreach ($chunk as $item) {
                    $language = [
                        'iso639_1'   => $item[2],
                        'iso639_2'   => $item[1],
                        'iso639_3'   => $item[0],
                        'name'       => $item[3],
                    ];

                    $languages->push($language);
                }

                DB::table('languages')
                    ->upsert($languages->all(), [
                        'iso639_3',
                    ]);
            });
    }
}
