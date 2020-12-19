<?php

namespace App\Imports;

use App\Continent;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\CountriesFileIterator;
use App\Imports\Iterators\GeonamesFileIterator;
use Carbon\Carbon;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

class ContinentsImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Continent codes
     *
     * @var \Illuminate\Support\Collection
     */
    public $continentCodes;

    /**
     * Initialize an instance
     *
     * @param string $filepath
     * @param string $delimiter
     * @return void
     */
    public function __construct(string $filepath, string $delimiter = "\t")
    {
        parent::__construct($filepath, $delimiter);

        $this->continentCodes = self::loadContinentCodes();
    }

    /**
     * Decides whether to skip a row or not
     *
     * @param array  @row
     * @return boolean
     */
    public function skip(array $row)
    {
        $codes = $this->continentCodes->map(function ($code) {
            return Str::finish($code, ' : ');
        });

        return !Str::startsWith($row[0], $codes->all());
    }

    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $data = $this
            ->iterable()
            ->map(function (array $data) {
                $now = Carbon::now();
                
                [$code, $name] = Str::of($data[0])->explode(' : ');
                
                return [
                    'code' => $code,
                    'name' => $name,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            });

        Continent::insert($data->all());
    }

    /**
     * Collect all continent codes from the countryInfo.txt file
     *
     * @return \Illuminate\Support\Collection
     */
    private static function loadContinentCodes()
    {
        $path = resolve(FilesystemAdapter::class)
            ->path(config('geonames.countries_file'));

        $continentCodes = (new CountriesFileIterator($path))
            ->iterable()
            ->pluck(8)
            ->unique()
            ->filter()
            ->all();

        return collect($continentCodes);
    }
}
