<?php

namespace App\Console\Commands;

use App\Imports\ContinentsImport;
use App\Imports\CountriesImport;
use App\Imports\CountryCurrencyImport;
use App\Imports\CountryLanguageImport;
use App\Imports\CurrenciesImport;
use App\Imports\FeatureClassesImport;
use App\Imports\FeatureCodesImport;
use App\Imports\FlagsImport;
use App\Imports\LanguagesImport;
use App\Imports\NeighbourCountriesImport;
use App\Imports\PlacesImport;
use App\Imports\TimeZonesImport;
use App\Models\Country;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ImportGeonamesFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all the required Geoname files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $filesystem = new Filesystem();

        $filesystem->ensureDirectoryExists(storage_path('app'));

        $dispatcher = app()->make(\Illuminate\Contracts\Bus\Dispatcher::class);
        $dispatcher->batch([
            new ContinentsImport(storage_path('app/'.config('geonames.readme_file'))),
            new CurrenciesImport(storage_path('app/'.config('geonames.countries_file'))),
            new CountriesImport(storage_path('app/'.config('geonames.countries_file'))),
            new TimeZonesImport(storage_path('app/'.config('geonames.time_zones_file'))),
            new LanguagesImport(storage_path('app/'.config('geonames.language_codes_file'))),
            new NeighbourCountriesImport(storage_path('app/'.config('geonames.countries_file'))),
            new FeatureClassesImport(storage_path('app/'.config('geonames.readme_file'))),
            new FeatureCodesImport(storage_path('app/'.config('geonames.feature_codes_file'))),
            new FlagsImport(),
            new CountryLanguageImport(storage_path('app/'.config('geonames.countries_file'))),
            new CountryCurrencyImport(storage_path('app/'.config('geonames.countries_file'))),
        ])->then(function (Batch $batch) {
            Country::cursor()
                ->each(function (Country $country) use ($batch) {
                    $code = $country->iso3166_alpha2;

                    $filepath = storage_path('app/data/'.$code.'/'.$code.'.txt');

                    $batch->add([new PlacesImport($filepath)]);
                });
        })
        ->onQueue('import')
        ->dispatch();
    }
}
