<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadCountriesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'data';

    /**
     * The Geonames file containing all country information
     * 
     * @var string
     */
    const COUNTRIES_FILE = 'countryInfo.txt';

    /**
     * An instance of the storage disk object
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
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
        try {
            $response =  Http::withOptions([
                'stream' => true
            ])->get($this->url());


            if ($response->failed()) {
                throw new FileNotDownloadedException($this->url());
            }

            $saved = $this->disk->put(
                static::COUNTRIES_FILE, $response->getBody()
            );

            if (!$saved) {
                throw new FileNotSavedException(
                    $this->disk->path(static::COUNTRIES_FILE)
                );
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * The location of the file
     * 
     * @return string
     */
    private function url()
    {
        return config('geonames.url') . '/' . static::COUNTRIES_FILE;
    }
}
