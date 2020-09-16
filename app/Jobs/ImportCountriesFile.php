<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Country;
use App\Exceptions\FileNotDownloadedException;
use App\Exceptions\FileNotSavedException;

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
     * The Geonames file containing all country information
     * 
     * @var string
     */
    const COUNTRIES_FILE = 'countryInfo.txt';

    /**
     * The delimiter used to parse the file
     * 
     * @var string
     */
    const DELIMITER = "\t";

    /**
     * An instance of the storage disk object
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
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
        $fh = fopen($this->disk->path(static::COUNTRIES_FILE), 'r');

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
                    'code' => $data[0],
                    'name' => $data[4],
                    'area' => $data[6],
                    'population' => $data[7],
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
     * @param string $code
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
            $this->flagFilepath($code), $response->getBody()
        );

        if (!$saved) {
            throw new FileNotSavedException($this->flagFilepath(($code)));
        }
        
        return $this->flagFilepath($code);
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
    private function flagUrl (string $code)
    {
        return config('flags.url') . '/' . $this->flagFilename($code);
    }
}
