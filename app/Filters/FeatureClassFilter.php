<?php

namespace App\Filters;

use App\Models\FeatureClass;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class FeatureClassFilter extends Filter
{
    /**
     * Return the model classname to be filtered
     *
     * @return string
     */
    public function modelClass(): string
    {
        return FeatureClass::class;
    }

    /**
     * The attributes we can use to filter countries
     *
     * @var array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('code'),
        ];
    }

    /**
     *
     */
    public function getAllowedIncludes() : array
    {
        return [
            AllowedInclude::relationship('featureCodes')
        ];
    }
}
