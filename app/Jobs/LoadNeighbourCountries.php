<?php

namespace App\Jobs;

use App\Country;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
     * The delimiter used to parse the file
     *
     * @var string
     */
    const DELIMITER = "\t";

    /**
     * An instance of the storage disk object
     *
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    public $disk;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->disk = Storage::disk(static::DISK);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fh = fopen($this->disk->path($this->countriesFilename()), 'r');

        while ($line = fgets($fh, 2048)) {
            if (Str::startsWith($line, '#')) {
                continue;
            }

            $data = str_getcsv($line, static::DELIMITER);
            
            $neighbours = Str::of($data[17])->trim();

            if ($neighbours->isEmpty()) {
                continue;
            }

            // Find the parent country
            $country = Country::query()
                ->where('iso3166_alpha2', $data[0])
                ->first();
            
            if (!$country) {
                continue;
            }

            $neighbours->explode(',')
                ->each(function ($code) use ($country) {
                    $neighbour = Country::query()
                        ->where('iso3166_alpha2', $code)
                        ->first();
                    
                    if (!$neighbour) {
                        return;
                    }
                    
                    $country->neighbours()->attach($neighbour);
                });
        }

        fclose($fh);
    }

    /**
     * The name of the countries file
     *
     * @return string
     */
    private function countriesFilename()
    {
        return config('geonames.countries_file');
    }
}
