<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class DownloadCountriesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'local';

    /**
     * The Geonames file containing all country information
     * 
     * @var string
     */
    const COUNTRIES_FILE = 'countryInfo.txt';

    /**
     * The folder where the file should be stored
     *
     * @var string
     */
    const FOLDER_NAME = 'data';

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
            ])->get($this->url() . '/' . static::COUNTRIES_FILE);


            if ($response->failed()) {
                throw new FileNotDownloadedException(static::COUNTRIES_FILE);
            }

            $this->disk->put($this->path(), $response->getBody());
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * The url
     * 
     * @return string
     */
    private function url()
    {
        return config('geonames.url');
    }

    /**
     * The path where the downloaded file should be saved
     * 
     * @return string
     */
    private function path()
    {
        return static::FOLDER_NAME . '/' . static::COUNTRIES_FILE;
    }
}
