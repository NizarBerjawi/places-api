<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Jobs\Traits\Unzippable;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Http;

class DownloadAlternateNamesFiles extends GeonamesJob
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

        $response = Http::timeout(static::TIMEOUT)
            ->withOptions([
                'sink' => $this->filepath(),
            ])->get($this->url());

        if ($response->failed()) {
            return $this->fail(new FileNotDownloadedException($this->url()));
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
        return config('geonames.alternate_names_zip_url');
    }

    /**
     * The name of the language codes file.
     *
     * @return string
     */
    public function filename()
    {
        return config('geonames.alternate_names_zip_file');
    }

    /**
     * The location where the file should be stored.
     *
     * @return string
     */
    public function filepath()
    {
        return $this->folderPath().'/'.$this->filename();
    }

    /**
     * The folder path where the downloaded file should be saved.
     *
     * @return string
     */
    private function folderPath()
    {
        return storage_path('app/data/alternateNames');
    }
}
