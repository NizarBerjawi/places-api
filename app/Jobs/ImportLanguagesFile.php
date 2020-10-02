<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Language;
use App\Exceptions\FileNotDownloadedException;

class ImportLanguagesFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The storage disk name
     *
     * @var string
     */
    const DISK = 'data';

    /**
     * The Geonames file containing all languages information
     * 
     * @var string
     */
    const LANGUAGES_FILE = 'iso-languagecodes.txt';

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
        $fh = fopen($this->disk->path(static::LANGUAGES_FILE), 'r');

        $headerSkipped = false;
        while ($line = fgets($fh, 2048)) {
            // skip comments
            if (Str::startsWith($line, '#')) {
                continue;
            }
            
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            $data = collect(str_getcsv($line, static::DELIMITER))
                ->map(function($item) {
                    if (empty($item)) {
                        return null;
                    }

                    return $item;
                });

            try {
                $language = Language::create([
                    'iso639_1' => $data[2],
                    'iso639_2' => $data[1],
                    'iso639_3' => $data[0],
                    'language_name' => $data[3],
                ]);
            } catch (FileNotDownloadedException $e) {
                logger($e->getMessage());
            }
        }

        fclose($fh);
    }
}
