<?php

namespace App\Imports;

use App\FeatureClass;
use App\FeatureCode;
use App\Imports\Concerns\GeonamesImportable;
use App\Imports\Iterators\GeonamesFileIterator;
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
        $featureClasses = FeatureClass::get();

        $data = $this
            ->iterable()
            ->map(function ($row) use ($featureClasses) {
                [$featureClassCode, $featureCode] = explode('.', $row[0]);
                $timestamp = Carbon::now()->toDateTimeString();

                $featureClass = $featureClasses
                    ->where('code', $featureClassCode)
                    ->first();
                
                return [
                    'code' => $featureCode,
                    'short_description' => ucfirst($row[1]),
                    'full_description' => ucfirst($row[2]),
                    'feature_class_id' => $featureClass->id,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
            });

        FeatureCode::insert($data->all());
    }
}
