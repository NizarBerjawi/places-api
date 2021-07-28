<?php

namespace App\Console\Commands;

use App\Imports\Iterators\CountriesFileIterator;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadCountryFlag;
use App\Jobs\DownloadFeatureCodesFile;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadInfoFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\DownloadTimezonesFile;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

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
        dispatch_now(new DownloadInfoFile());
        dispatch_now(new DownloadCountriesFile);
        dispatch_now(new DownloadLanguages);
        dispatch_now(new DownloadFeatureCodesFile);
        dispatch_now(new DownloadTimezonesFile);

        $path = storage_path('app/'.config('geonames.countries_file'));

        if ((new Filesystem)->exists($path)) {
            (new CountriesFileIterator($path))
                ->iterable()
                ->each(function (array $row) {
                    $code = Arr::get($row, 0);
                    dispatch(new DownloadCountryFlag($code))->onQueue('download');
                    dispatch(new DownloadGeonamesFile($code))->onQueue('download');
                });
        }
    }
}
