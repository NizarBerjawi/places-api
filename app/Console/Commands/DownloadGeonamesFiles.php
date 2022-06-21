<?php

namespace App\Console\Commands;

use App\Imports\Iterators\CountriesFileIterator;
use App\Jobs\DownloadAlternateNamesFiles;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadCountryFlag;
use App\Jobs\DownloadFeatureCodesFile;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadInfoFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\DownloadShapesFile;
use App\Jobs\DownloadTimezonesFile;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Laravel\Lumen\Application;

class DownloadGeonamesFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download all the required Geoname files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $basePath = storage_path('app/data');

        (new Filesystem)
            ->ensureDirectoryExists($basePath);

        Application::getInstance()
            ->make(Dispatcher::class)
            ->batch([
                new DownloadCountriesFile,
                new DownloadInfoFile,
                new DownloadLanguages,
                new DownloadFeatureCodesFile,
                new DownloadTimezonesFile,
                new DownloadAlternateNamesFiles,
                new DownloadShapesFile,
            ])->then(function (Batch $batch) use ($basePath) {
                if ($batch->finished()) {
                    $path = $basePath.'/'.config('geonames.countries_file');

                    (new CountriesFileIterator($path))
                        ->iterable()
                        ->each(function (array $row) {
                            $countryCode = Arr::first($row);

                            dispatch(
                                new DownloadCountryFlag($countryCode)
                            )->onQueue('download-flags');

                            dispatch(
                                new DownloadGeonamesFile($countryCode)
                            )->onQueue('download-places');
                        });
                }
            })
            ->onQueue('download-data')
            ->dispatch();
    }
}
