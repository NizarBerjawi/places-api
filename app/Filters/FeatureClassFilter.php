<?php

namespace App\Filters;

use App\Models\FeatureClass;
use Spatie\QueryBuilder\AllowedFilter;

class FeatureClassFilter extends Filter
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return FeatureClass::class;
    }

    /**
     * The attributes we can use to filter countries.
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
     * The relations that we can include.
     *
     * @var array
     */
    public function getAllowedIncludes() : array
    {
        return [];
    }
}
