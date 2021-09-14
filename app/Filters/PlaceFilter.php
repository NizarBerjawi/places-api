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
     * The attributes we can use to filter.
     *
     * @return array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('name'),
            AllowedFilter::exact('featureCode', 'feature_code'),
            AllowedFilter::exact('countryCode', 'country_code'),
            AllowedFilter::exact('timeZoneCode', 'timeZone_code'),
            AllowedFilter::exact('population'),
            AllowedFilter::exact('elevation'),
            AllowedFilter::scope('populationGt'),
            AllowedFilter::scope('populationGte'),
            AllowedFilter::scope('populationLt'),
            AllowedFilter::scope('populationLte'),
            AllowedFilter::scope('populationBetween'),
            AllowedFilter::scope('elevationGt'),
            AllowedFilter::scope('elevationGte'),
            AllowedFilter::scope('elevationLt'),
            AllowedFilter::scope('elevationLte'),
            AllowedFilter::scope('elevationBetween'),
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
            'country',
            'location',
            'featureClass',
            'featureCode',
            'timeZone',
        ];
    }
}
