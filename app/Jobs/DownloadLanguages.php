<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use Illuminate\Support\Facades\Http;

class DownloadLanguages extends GeonamesJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $response = Http::withOptions([
                'stream' => true,
            ])->get($this->url());

            if ($response->failed()) {
                throw new FileNotDownloadedException($this->url());
            }

            $saved = $this
                ->filesystem
                ->put($this->filepath(), $response->getBody());

            if (! $saved) {
                throw new FileNotSavedException($this->filepath());
            }
        } catch (\Exception $e) {
            $this->log($e->getMessage(), 'warning');
        }
    }

    /**
     * The location of the file.
     *
     * @return string
     */
    public function url()
    {
        return config('geonames.language_codes_url');
    }

    /**
     * The name of the language codes file.
     *
     * @return string
     */
    public function filename()
    {
        return config('geonames.language_codes_file');
    }

    /**
     * The location where the file should be stored.
     *
     * @return string
     */
    public function filepath()
    {
        return storage_path('app/'.$this->filename());
    }
}
