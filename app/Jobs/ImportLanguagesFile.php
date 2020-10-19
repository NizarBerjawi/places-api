<?php

namespace App\Jobs;

use App\Imports\LanguagesImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = Storage::disk(static::DISK)
            ->path($this->filename());

        try {
            Excel::import(new LanguagesImport, $path);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

    /**
     * The name of the language codes file
     *
     * @return string
     */
    private function filename()
    {
        return config('geonames.language_codes_file');
    }
}
