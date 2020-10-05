<?php

namespace App\Jobs;

use App\Country;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UnzipGeonamesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'data';

    /**
     * An instance of the storage disk object
     *
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    public $disk;

    /**
     * A country to unzip geonames for
     * 
     * @var Country
     */
    public $country;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Country $country)
    {
        $this->country = $country;
        
        $this->disk = Storage::disk(static::DISK);
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
        
        if (!$res) {
            throw new \Exception("Could not unzip file: " . $this->fileName());
        }

        $zip->extractTo($this->folderPath());
        $zip->close();
    }

    /**
     * The name of the file
     * 
     * @return zip
     */
    private function filename()
    {
        return $this->country->iso3166_alpha2 . '.zip';
    }

    /**
     * The folder path where the downloaded file should be saved
     * 
     * @return string
     */
    private function folderPath()
    {
        return $this->disk->path($this->country->iso3166_alpha2);
    }

    /**
     * The full path of the downloaded file
     * 
     * @return string
     */
    private function filepath() 
    {
        return $this->folderPath() . '/' . $this->filename();
    }
}
