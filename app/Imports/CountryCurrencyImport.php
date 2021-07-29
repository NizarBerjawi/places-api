<?php

namespace App\Imports;

use App\Imports\Iterators\CountriesFileIterator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CountryCurrencyImport extends CountriesFileIterator implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $countryCurrencies = collect();

        foreach ($this->iterable() as $item) {
            if (! isset($item[10], $item[11])) {
                continue;
            }

            $countryCurrencies->push([
                'country_code'  => $item[0],
                'currency_code' => $item[10],
            ]);
        }

        DB::table('country_currency')->insert($countryCurrencies->all());
    }
}
