<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use App\Jobs\Traits\Unzippable;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Http;

class DownloadShapesFile extends GeonamesJob
{
    use Batchable, Unzippable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this
            ->filesystem
            ->ensureDirectoryExists($this->folderPath());

        $response = Http::withOptions([
            'stream' => true,
        ])->get($this->url());

        if ($response->failed()) {
            return $this->fail(new FileNotDownloadedException($this->url()));
        }

        $saved = $this
            ->filesystem
            ->put($this->filepath(), $response->getBody());

        if (! $saved) {
            return $this->fail(new FileNotSavedException($this->filepath()));
        }

        $this->unzip();
    }

    /**
     * The location of the file.
     *
     * @return string
     */
    public function url()
    {
        return config('geonames.shapes_zip_url');
    }

    /**
     * The name of the countries file.
     *
     * @return string
     */
    public function filename()
    {
        return config('geonames.shapes_zip_file');
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

    /**
     * The folder path where the downloaded file should be saved.
     *
     * @return string
     */
    private function folderPath()
    {
        return storage_path('app/data/shapes');
    }
}
