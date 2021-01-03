<?php

namespace App\Imports;

use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
use App\Models\FeatureClass;
use App\Models\FeatureCode;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FeatureCodesImport extends GeonamesFileIterator implements GeonamesImportable
{
    /**
     * Decides whether to skip a row or not
     *
     * @param array  $row
     * @param boolean
     */
    public function skip(array $row)
    {
        return Str::is($row[0], 'null');
    }

    /**
     * Import the required data into the database
     *
     * @return void
     */
    public function import()
    {
        $featureCodes = collect();
        $featureClasses = FeatureClass::get();

        foreach ($this->iterable() as $item) {
            if ($this->skip($item)) {
                continue;
            }

            $data = Str::of($item[0])->explode('.');
            $featureClassCode = $data->first();
            $featureCode = $data->last();

            $timestamp = Carbon::now()->toDateTimeString();

            $featureCodes->push([
                'code' => $featureCode,
                'short_description' => ucfirst($item[1]),
                'full_description' => ucfirst($item[2]),
                'feature_class_code' => $featureClassCode,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);
        }

        FeatureCode::insert($featureCodes->all());
    }
}
