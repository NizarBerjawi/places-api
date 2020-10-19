<?php

namespace App\Jobs;

use App\Imports\NeighbourCountriesImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class LoadNeighbourCountries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'data';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = Storage::disk(static::DISK)
            ->path($this->filename());

        try {
            Excel::import(new NeighbourCountriesImport, $path);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * The name of the countries file
     *
     * @return string
     */
    private function filename()
    {
        return config('geonames.countries_file');
    }
}
