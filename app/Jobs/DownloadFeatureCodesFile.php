<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class DownloadFeatureCodesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FilesystemAdapter $disk)
    {
        try {
            $response =  Http::withOptions([
                'stream' => true
            ])->get($this->url());
    
            if ($response->failed()) {
                throw new FileNotDownloadedException($this->url());
            }
    
            $saved = $disk->put($this->filename(), $response->getBody());
    
            if (!$saved) {
                throw new FileNotSavedException($disk->path($this->filename()));
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * The location of the file
     *
     * @return string
     */
    private function url()
    {
        return config('geonames.feature_codes_url');
    }

    /**
     * The name of the countries file
     *
     * @return string
     */
    private function filename()
    {
        return config('geonames.feature_codes_file');
    }
}
