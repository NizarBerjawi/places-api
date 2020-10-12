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
use Illuminate\Support\Str;

class ImportCountriesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'data';

    /**
     * The delimiter used to parse the file
     *
     * @var string
     */
    const DELIMITER = "\t";

    /**
     * An instance of the storage disk object
     *
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    public $disk;

    /**
     * Dissolved countries that don't exist any more.
     *
     * @var array
     */
    public $excluded = ['CS', 'AN'];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->disk = Storage::disk(static::DISK);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fh = fopen($this->disk->path($this->countriesFilename()), 'r');

        while ($line = fgets($fh, 2048)) {
            if (Str::startsWith($line, '#')) {
                continue;
            }

            $data = str_getcsv($line, static::DELIMITER);

            if (in_array($data[0], $this->excluded)) {
                continue;
            }

            try {
                $country = Country::create([
                    'name' => $data[4],
                    'iso3166_alpha2' => $data[0],
                    'iso3166_alpha3' => $data[1],
                    'iso3166_numeric' => $data[2],
                    'population' => $data[7],
                    'area' => $data[6],
                    'phone_code' => $data[12],
                    'flag' => $this->downloadFlag($data[0])
                ]);
            } catch (FileNotDownloadedException $e) {
                logger($e->getMessage());
            }
        }

        fclose($fh);
    }

    /**
     * Download a country's flag
     *
     * @param string $code~
     * @return string
     */
    private function downloadFlag(string $code)
    {
        $response =  Http::withOptions([
            'stream' => true
        ])->get($this->flagUrl($code));

        if ($response->failed()) {
            throw new FileNotDownloadedException($this->flagUrl($code));
        }

        $saved = $this->disk->put(
            $this->flagFilepath($code),
            $response->getBody()
        );

        if (!$saved) {
            throw new FileNotSavedException($this->flagFilepath(($code)));
        }

        return $this->flagFilepath($code);
    }

    /**
     * The name of the countries file
     *
     * @return string
     */
    private function countriesFilename()
    {
        return config('geonames.countries_file');
    }

    /**
     * Get the flag filename
     *
     * @param string $code
     * @return string
     */
    private function flagFilename(string $code)
    {
        return strtolower($code . '.gif');
    }

    /**
     * Get the flag filepath
     *
     * @param string $code
     * @return string
     */
    private function flagFilepath(string $code)
    {
        return $code . '/' . $this->flagFilename($code);
    }

    /**
     * Get the url of the flag
     *
     * @param string $code
     * @return string
     */
    private function flagUrl(string $code)
    {
        return config('geonames.flags_url') . '/' . $this->flagFilename($code);
    }
}
