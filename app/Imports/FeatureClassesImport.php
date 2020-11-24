<?php

namespace App\Imports;

use App\FeatureClass;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

class FeatureClassesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Continent codes
     *
     * @var \Illuminate\Support\Collection
     */
    public $featureClasses;

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

        $this->featureClasses = self::loadFeatureClasses();
    }

    /**
     * Decides whether to skip a row or not
     *
     * @param array  $row
     * @param boolean
     */
    public function skip(array $row)
    {
        $codes = $this->featureClasses->map(function ($code) {
            return Str::finish($code, ': ');
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
            ->map(function ($row) {
                [$code, $description] = explode(': ', $row[0]);

                return [
                    'code'  => $code,
                    'description' => ucfirst($description)
                 ];
            });

        FeatureClass::insert($data->all());
    }

    /**
     * Collect all continent codes from the countryInfo.txt file
     *
     * @return \Illuminate\Support\Collection
     */
    private static function loadFeatureClasses()
    {
        $path = resolve(FilesystemAdapter::class)
            ->path(config('geonames.feature_codes_file'));

        $featureClasses = (new GeonamesFileIterator($path))
            ->iterable()
            ->flatMap(function ($row) {
                if (! Str::contains($row[0], '.')) {
                    return;
                }

                [$featureClass, $featureCode] = explode('.', $row[0]);

                return [
                    'code' => $featureClass
                ];
            })
            ->unique()
            ->all();

        return collect($featureClasses);
    }
}
