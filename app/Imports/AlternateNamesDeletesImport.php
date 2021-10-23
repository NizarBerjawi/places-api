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

class AlternateNamesDeletesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $this->iterable()
            ->chunk(500)
            ->each(function (LazyCollection $chunk) {
                $ids = Collection::make();

                foreach ($chunk as $item) {
                    $ids->push($item[0]);
                }

                DB::table('alternate_names')
                    ->whereIn('id', $ids)
                    ->delete();
            });
    }
}
