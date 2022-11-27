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

class CurrenciesImport extends CountriesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $currencies = Collection::make();

        foreach ($this->iterable() as $item) {
            [$code, $name] = [$item[10], $item[11]];

            if (! isset($code, $name)) {
                continue;
            }

            $reject = $currencies->contains(
                function (array $currency) use ($code) {
                    return $currency['code'] === $code;
                }
            );

            if ($reject) {
                continue;
            }

            $currencies->push([
                'code' => $code,
                'name' => $name,
            ]);
        }

        DB::table('currencies')
            ->upsert($currencies->all(), [
                'code',
            ]);
    }
}
