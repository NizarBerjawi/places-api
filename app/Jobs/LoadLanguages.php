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

class LoadLanguages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'data';

    /**
     * The Geonames file containing all languages information
     * 
     * @var string
     */
    const LANGUAGES_FILE = 'iso-languagecodes.txt';

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
           $this->downloadFile();
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Downloads the languages file
     * 
     * @return string
     */
    private function downloadFile()
    {
        $response =  Http::withOptions([
            'stream' => true
        ])->get($this->url());


        if ($response->failed()) {
            throw new FileNotDownloadedException($this->url());
        }

        $saved = $this->disk->put(
            static::LANGUAGES_FILE, $response->getBody()
        );

        if (!$saved) {
            throw new FileNotSavedException($this->filePath());
        }

        return $this->filePath();
    }

    /**
     * The location of the file
     * 
     * @return string
     */
    private function url()
    {
        return config('geonames.language_codes') . '/' . static::COUNTRIES_FILE;
    }

    /**
     * The full path of the countries file
     * 
     * @return string
     */
    private function filePath()
    {
        return $this->disk->path(static::COUNTRIES_FILE);
    }

}
