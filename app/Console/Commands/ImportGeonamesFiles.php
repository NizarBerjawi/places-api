<?php

namespace App\Console\Commands;

use App\Imports\AlternateNamesImport;
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
use App\Imports\ShapesImport;
use App\Imports\TimeZonesImport;
use App\Models\Country;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Laravel\Lumen\Application;

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
        $basePath = storage_path('app/data');

        Application::getInstance()
            ->make(Dispatcher::class)
            ->batch([
                new ContinentsImport($basePath.'/'.config('geonames.readme_file')),
                new CurrenciesImport($basePath.'/'.config('geonames.countries_file')),
                new CountriesImport($basePath.'/'.config('geonames.countries_file')),
                new TimeZonesImport($basePath.'/'.config('geonames.time_zones_file')),
                new LanguagesImport($basePath.'/'.config('geonames.language_codes_file')),
                new NeighbourCountriesImport($basePath.'/'.config('geonames.countries_file')),
                new FeatureClassesImport($basePath.'/'.config('geonames.readme_file')),
                new FeatureCodesImport($basePath.'/'.config('geonames.feature_codes_file')),
                new FlagsImport($basePath.'/'.config('geonames.countries_file')),
                new CountryLanguageImport($basePath.'/'.config('geonames.countries_file')),
                new CountryCurrencyImport($basePath.'/'.config('geonames.countries_file')),
                new ShapesImport($basePath.'/shapes/'.config('geonames.shapes_file')),
            ])->then(function (Batch $batch) use ($basePath) {
                if ($batch->finished()) {
                    Country::cursor()
                        ->each(function (Country $country) use ($basePath) {
                            $code = $country->iso3166_alpha2;

                            $filepath = $basePath.'/geonames/'.$code.'/'.$code.'.txt';

                            dispatch(new PlacesImport($filepath))
                                ->onQueue('import-places');
                        });
                }
            })
            ->finally(function (Batch $batch) use ($basePath) {
                if ($batch->finished()) {
                    dispatch(
                        new AlternateNamesImport(
                            $basePath.'/alternateNames/'.config('geonames.alternate_names_file')
                        )
                    )->onQueue('import-names');
                }
            })
            ->onQueue('import-data')
            ->dispatch();
    }
}
