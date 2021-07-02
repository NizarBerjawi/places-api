<?php

namespace App\Jobs;

use App\Exceptions\FileNotDeletedException;
use App\Jobs\Traits\HasPlaceholders;
use Carbon\Carbon;

class DeleteDeletesFile extends GeonamesJob
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
            $deleted = $this
                ->filesystem
                ->delete($this->filepath());

            if (! $deleted) {
                throw new FileNotDeletedException($this->filename());
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

        $date = Carbon::yesterday()->subDays(1)->format('Y-m-d');

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

        $date = Carbon::yesterday()->subDays(1)->format('Y-m-d');

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
