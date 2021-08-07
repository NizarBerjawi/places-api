<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use App\Jobs\Traits\HasPlaceholders;
use Illuminate\Support\Facades\Http;

class DownloadDeletesFile extends GeonamesJob
{
    use HasPlaceholders;

    public $date;

    public function __construct(string $date)
    {
        parent::__construct();

        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->log($this > url(), 'warning');

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
                throw new FileNotSavedException($this->filename());
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
        $url = config('geonames.deletes_url');

        return $this->replace('date', $this->date, $url);
    }

    /**
     * The name of the info file.
     *
     * @return string
     */
    public function filename()
    {
        $filename = config('geonames.deletes_file');

        return $this->replace('date', $this->date, $filename);
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
