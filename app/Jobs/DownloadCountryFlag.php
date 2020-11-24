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

class DownloadCountryFlag implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * A country code to download flag image for
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
            $response =  Http::withOptions([
                'stream' => true
            ])->get($this->url($this->code));
    
            if ($response->failed()) {
                throw new FileNotDownloadedException($this->url($this->code));
            }
    
            $saved = $disk->put(
                $this->filepath($this->code),
                $response->getBody()
            );
    
            if (!$saved) {
                throw new FileNotSavedException($this->filepath(($this->code)));
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Get the flag filename
     *
     * @param string $code
     * @return string
     */
    private function filename(string $code)
    {
        return strtolower($code . '.gif');
    }

    /**
     * Get the flag filepath
     *
     * @param string $code
     * @return string
     */
    private function filepath(string $code)
    {
        return $code . '/' . $this->filename($code);
    }

    /**
     * Get the url of the flag
     *
     * @param string $code
     * @return string
     */
    private function url(string $code)
    {
        return config('geonames.flags_url') . '/' . $this->filename($code);
    }
}
