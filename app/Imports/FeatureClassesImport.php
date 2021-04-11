<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\FeatureClass;
use Carbon\Carbon;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FeatureClassesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Feature Classes.
     *
     * @var \Illuminate\Support\Collection
     */
    public $featureClasses;

    /**
     * Initialize an instance.
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
     * Decides whether to skip a row or not.
     *
     * @param array  $row
     * @param bool
     */
    public function skip(array $row)
    {
        $codes = $this->featureClasses->map(function (string $code) {
            return Str::finish($code, ': ');
        });

        return ! Str::startsWith($row[0], $codes->all());
    }

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import()
    {
        $featureClasses = Collection::make();
        foreach ($this->iterable() as $item) {
            if ($this->skip($item)) {
                continue;
            }

            [$code, $description] = Str::of($item[0])->explode(': ');

            if (! isset($code, $description)) {
                continue;
            }

            $timestamp = Carbon::now()->toDateTimeString();
            $featureClasses->push([
                'code'        => $code,
                'description' => ucfirst($description),
                'created_at'  => $timestamp,
                'updated_at'  => $timestamp,
            ]);
        }

        FeatureClass::insert($featureClasses->all());
    }

    /**
     * Collect all continent codes from the countryInfo.txt file.
     *
     * @return \Illuminate\Support\Collection
     */
    private static function loadFeatureClasses()
    {
        $path = resolve(FilesystemAdapter::class)
            ->path(config('geonames.feature_codes_file'));

        $iterable = (new GeonamesFileIterator($path))->iterable();

        $featureClasses = Collection::make();

        foreach ($iterable as $item) {
            $featureClassString = Str::of($item[0]);

            if (! $featureClassString->contains('.')) {
                continue;
            }

            $featureClass = $featureClassString->explode('.')->first();

            if (! $featureClass || $featureClasses->contains($featureClass)) {
                continue;
            }

            $featureClasses->push($featureClass);
        }

        return $featureClasses;
    }
}
