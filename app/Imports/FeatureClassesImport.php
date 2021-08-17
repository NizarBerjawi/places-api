<?php

namespace App\Imports;

use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\FeatureClass;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class FeatureClassesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

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
    public function handle()
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

            $featureClasses->push([
                'code'        => $code,
                'description' => ucfirst($description),
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
        $path = storage_path('app/data/'.config('geonames.feature_codes_file'));

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
