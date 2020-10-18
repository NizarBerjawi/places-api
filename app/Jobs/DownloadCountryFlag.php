<?php

namespace App\Jobs;

use App\Country;
use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadCountryFlag implements ShouldQueue
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
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    public $disk;

    /**
     * The base url to download the cities data from
     *DownloadCountryFlag
     * @var string
     */
    public $url;

    /**
     * A country to download flag image for
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
        try {
            $this->downloadFile($this->country->iso3166_alpha2);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * Downloads the Geoames file for a country
     *
     * @return void
     */
    private function downloadFile(string $code)
    {
        $response =  Http::withOptions([
            'stream' => true
        ])->get($this->url($code));

        if ($response->failed()) {
            throw new FileNotDownloadedException($this->url($code));
        }

        $saved = $this->disk->put(
            $this->filepath($code),
            $response->getBody()
        );

        if (!$saved) {
            throw new FileNotSavedException($this->filepath(($code)));
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
