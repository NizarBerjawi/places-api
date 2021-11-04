<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Http;

class DownloadFeatureCodesFile extends GeonamesJob
{
    use Batchable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::withOptions([
            'stream' => true,
        ])->get($this->url());

        if ($response->failed()) {
            $this->fail(new FileNotDownloadedException($this->url()));
        }

        $saved = $this
            ->filesystem
            ->put($this->filepath(), $response->getBody());

        if (! $saved) {
            $this->fail(new FileNotSavedException($this->filepath()));
        }
    }

    /**
     * The location of the file.
     *
     * @return string
     */
    public function url()
    {
        return config('geonames.feature_codes_url');
    }

    /**
     * The name of the countries file.
     *
     * @return string
     */
    public function filename()
    {
        return config('geonames.feature_codes_file');
    }

    /**
     * The location where the file should be stored.
     *
     * @return string
     */
    public function filepath()
    {
        return storage_path('app/data/'.$this->filename());
    }
}
