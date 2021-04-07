<?php

namespace App\Filters;

use App\Models\Place;
use Spatie\QueryBuilder\AllowedFilter;

class PlaceFilter extends Filter
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return Place::class;
    }

    /**
     * The attributes we can use to filter countries.
     *
     * @var array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('feature_code'),
            AllowedFilter::exact('country_code'),
            AllowedFilter::scope('population_gt'),
            AllowedFilter::scope('population_gte'),
            AllowedFilter::scope('population_lt'),
            AllowedFilter::scope('population_lte'),
            AllowedFilter::scope('population_between'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @var array
     */
    public function getAllowedIncludes() : array
    {
        return [
            'country',
            'location',
            'featureCode'
        ];
    }
}
