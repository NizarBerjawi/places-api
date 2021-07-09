<?php

namespace App\Jobs;

use App\Exceptions\FileNotDeletedException;

class DeleteGeonamesFile extends GeonamesJob
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
            $deleted = $this
                ->filesystem
                ->deleteDirectory($this->folderPath());

            if (! $deleted) {
                throw new FileNotDeletedException($this->folderPath());
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
        //
    }

    /**
     * The name of the file.
     *
     * @return string
     */
    public function filename()
    {
        //
    }

    /**
     * The location where the file should be stored.
     *
     * @return string
     */
    public function filepath()
    {
        //
    }

    /**
     * The folder path where the downloaded file should be saved.
     *
     * @return string
     */
    private function folderPath()
    {
        return storage_path('app/data/'.$this->code);
    }
}
