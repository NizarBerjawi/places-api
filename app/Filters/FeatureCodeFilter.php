<?php

namespace App\Filters;

use App\Models\FeatureCode;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class FeatureCodeFilter extends Filter
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return FeatureCode::class;
    }

    /**
     * The attributes we can use to filter countries.
     *
     * @return array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('code'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @return array
     */
    public function getAllowedIncludes() : array
    {
        return [
            AllowedInclude::relationship('featureClass'),
        ];
    }
}
