<?php

namespace App\Imports;

use App\Imports\Iterators\GeonamesFileIterator;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeatureCodesImport extends GeonamesFileIterator implements ShouldQueue
{
    use Batchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Decides whether to skip a row or not.
     *
     * @param  array  $row
     * @param bool
     */
    public function skip(array $row)
    {
        return Str::is($row[0], 'null');
    }

    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function handle()
    {
        $featureCodes = Collection::make();

        foreach ($this->iterable() as $item) {
            if ($this->skip($item)) {
                continue;
            }

            $data = Str::of($item[0])->explode('.');
            $featureClassCode = $data->first();
            $featureCode = $data->last();

            $featureCodes->push([
                'code' => $featureCode,
                'short_description' => ucfirst($item[1]),
                'full_description' => ucfirst($item[2]),
                'feature_class_code' => $featureClassCode,
            ]);
        }

        DB::table('feature_codes')
            ->upsert($featureCodes->all(), [
                'code',
            ]);
    }
}
