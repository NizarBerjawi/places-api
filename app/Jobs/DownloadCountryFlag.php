<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use Illuminate\Support\Facades\Http;

class DownloadCountryFlag extends GeonamesJob
{
    /**
     * A country code to download flag image for.
     *
     * @var string
     */
    public $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $code)
    {
        parent::__construct();
        $this->code = $code;
    }

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

            $this
                ->filesystem
                ->ensureDirectoryExists($this->folderPath());

            $saved = $this
                ->filesystem
                ->put($this->filepath(), $response->getBody());

            if (! $saved) {
                throw new FileNotSavedException($this->filepath());
            }
        } catch (\Exception $e) {
            $this->fail($e);
            $this->log($e->getMessage(), 'warning');
        }
    }

    /**
     * Get the url of the flag.
     *
     * @return string
     */
    public function url()
    {
        return config('geonames.flags_url').'/'.strtolower($this->filename());
    }

    /**
     * Get the flag filename.
     *
     * @return string
     */
    public function filename()
    {
        return $this->code.'.gif';
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
        return storage_path('app/flags/');
    }
}
