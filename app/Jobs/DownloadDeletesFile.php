<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use App\Jobs\Traits\HasPlaceholders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DownloadDeletesFile extends GeonamesJob
{
    use HasPlaceholders;

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

        $date = Carbon::yesterday()->format('Y-m-d');

        return $this->replace('date', $date, $url);
    }

    /**
     * The name of the info file.
     *
     * @return string
     */
    public function filename()
    {
        $filename = config('geonames.deletes_file');

        $date = Carbon::yesterday()->format('Y-m-d');

        return $this->replace('date', $date, $filename);
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
