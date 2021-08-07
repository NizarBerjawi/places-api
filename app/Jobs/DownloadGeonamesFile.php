<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use Illuminate\Support\Facades\Http;

class DownloadGeonamesFile extends GeonamesJob
{
    /**
     * A country code to download geonames for.
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
            $this
                ->filesystem
                ->ensureDirectoryExists($this->folderPath());

            $response = Http::withOptions([
                'sink' => $this->filepath(),
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
        return config('geonames.files_url').'/'.$this->filename();
    }

    /**
     * The name of the file.
     *
     * @return string
     */
    public function filename()
    {
        return $this->code.'.zip';
    }

    /**
     * The location where the file should be stored.
     *
     * @return string
     */
    public function filepath()
    {
        return $this->folderPath().'/'.$this->fileName();
    }

    /**
     * The folder path where the downloaded file should be saved.
     *
     * @return string
     */
    private function folderPath()
    {
        return storage_path('app/data/geonames/'.$this->code);
    }

    /**
     * Unzip all downloaded Geoname files.
     *
     * @return void
     */
    private function unzip()
    {
        $zip = new \ZipArchive();

        $res = $zip->open($this->filepath());

        if (! $res) {
            throw new \Exception('Could not unzip file: '.$this->fileName());
        }

        $zip->extractTo($this->folderPath());
        $zip->close();
    }
}
