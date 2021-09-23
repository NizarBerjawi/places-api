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
        try {
            $this
                ->filesystem
                ->ensureDirectoryExists($this->folderPath());

            $response = Http::withOptions([
                'sink' => $this->filepath(),
                'verify' => false,
            ])->get($this->url());

            if ($response->failed()) {
                throw new FileNotDownloadedException($this->url());
            }

            $this->unzip();
        } catch (\Exception $e) {
            $this->fail($e);
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
        return config('geonames.alternate_names_url');
    }

    /**
     * The name of the language codes file.
     *
     * @return string
     */
    public function filename()
    {
        return config('geonames.alternate_names_file');
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
