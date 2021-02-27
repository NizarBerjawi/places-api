<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnzipGeonamesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * An instance of the storage disk object.
     *
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    public $disk;

    /**
     * A country code to unzip geonames for.
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
        $this->code = $code;

        $this->disk = resolve(FilesystemAdapter::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new \ZipArchive();

        $res = $zip->open($this->filepath());

        if (! $res) {
            throw new \Exception('Could not unzip file: '.$this->fileName());
        }

        $zip->extractTo($this->folderPath());
        $zip->close();
    }

    /**
     * The name of the file.
     *
     * @return zip
     */
    private function filename()
    {
        return $this->code.'.zip';
    }

    /**
     * The folder path where the downloaded file should be saved.
     *
     * @return string
     */
    private function folderPath()
    {
        return $this->disk->path($this->code);
    }

    /**
     * The full path of the downloaded file.
     *
     * @return string
     */
    private function filepath()
    {
        return $this->folderPath().'/'.$this->filename();
    }
}
