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
        try {
            $this->downloadFile();
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Downloads the countries file
     *
     * @return void
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
            $this->filename(),
            $response->getBody()
        );

        if (!$saved) {
            throw new FileNotSavedException($this->filepath());
        }
    }

    /**
     * The full path of the countries file
     *
     * @return string
     */
    private function filepath()
    {
        return $this->disk->path($this->filename());
    }

    /**
     * The location of the file
     *
     * @return string
     */
    private function url()
    {
        return config('geonames.countries_url');
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
