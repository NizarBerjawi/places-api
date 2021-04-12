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

class DownloadGeonamesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * A countrycode to download geonames for.
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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FilesystemAdapter $disk)
    {
        try {
            $response = Http::withOptions([
                'stream' => true,
            ])->get($this->url());

            if ($response->failed()) {
                throw new FileNotDownloadedException($this->url());
            }

            $saved = $disk->put($this->filepath(), $response->getBody());

            if (! $saved) {
                throw new FileNotSavedException($this->filepath());
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * The path where the downloaded file should be stored.
     *
     * @return string
     */
    private function filepath()
    {
        return $this->code.'/'.$this->fileName();
    }

    /**
     * The location of the file.
     *
     * @return string
     */
    private function url()
    {
        return config('geonames.files_url').'/'.$this->filename();
    }

    /**
     * The name of the file.
     *
     * @return string
     */
    private function filename()
    {
        return $this->code.'.zip';
    }
}
