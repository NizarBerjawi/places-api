<?php

namespace App\Imports;

use App\Imports\Iterators\CountriesFileIterator;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\Continent;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContinentsImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Continent codes.
     *
     * @var \Illuminate\Support\Collection
     */
    public $continentCodes;

    /**
     * Initialize an instance.
     *
     * @param  string  $filepath
     * @param  string  $delimiter
     * @return void
     */
    public function __construct(string $filepath, string $delimiter = "\t")
    {
        parent::__construct($filepath, $delimiter);

        $this->continentCodes = self::loadContinentCodes();
    }

    /**
     * Decides whether to skip a row or not.
     *
     * @param array  @row
     * @return bool
     */
    public function skip(array $row)
    {
        $codes = $this
            ->continentCodes
            ->map(function (string $code) {
                return Str::finish($code, ' : ');
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
        $continents = Collection::make();

        foreach ($this->iterable() as $item) {
            if ($this->skip($item)) {
                continue;
            }

            $data = collect($item)->filter()->values();

            [$code, $name] = Str::of($data->first())->explode(' : ');

            $geonameId = Str::of($data->last())->explode('=')->last();

            if (! isset($code, $name, $geonameId)) {
                continue;
            }

            $continents->push([
                'geoname_id' => $geonameId,
                'code' => $code,
                'name' => $name,
            ]);
        }

        DB::table('continents')
            ->upsert($continents->all(), [
                'geoname_id',
            ]);
    }

    /**
     * Collect all continent codes from the countryInfo.txt file.
     *
     * @return \Illuminate\Support\Collection
     */
    private static function loadContinentCodes()
    {
        $path = storage_path('app/data/'.config('geonames.countries_file'));

        $codes = (new CountriesFileIterator($path))
            ->iterable()
            ->pluck(8)
            ->filter()
            ->unique()
            ->values()
            ->collect();

        return $codes;
    }
}
