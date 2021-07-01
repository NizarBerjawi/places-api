<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\Iterators\CountriesFileIterator;
use App\Jobs\DownloadCountriesFile;
use App\Jobs\DownloadCountryFlag;
use App\Jobs\DownloadFeatureCodesFile;
use App\Jobs\DownloadGeonamesFile;
use App\Jobs\DownloadInfoFile;
use App\Jobs\DownloadLanguages;
use App\Jobs\DownloadTimezonesFile;
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
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        // 1- Download readme.txt file
        dispatch(new DownloadInfoFile());
        // 2- Download the countryInfo.txt file
        dispatch(new DownloadCountriesFile);
        // 3- Download the iso-languagecodes.txt file
        dispatch(new DownloadLanguages);
        // 4- Download the featureCodes_en.txt file
        dispatch(new DownloadFeatureCodesFile);
        // 5- Download the timeZones.txt file
        dispatch(new DownloadTimezonesFile);
        // 6- Download Geonames files related to every country
        $path = storage_path('app/'.config('geonames.countries_file'));
        (new CountriesFileIterator($path))
            ->iterable()
            ->each(function (array $row) {
                $code = Arr::get($row, 0);
                dispatch(new DownloadCountryFlag($code));
                dispatch(new DownloadGeonamesFile($code));
            });
    }
}
