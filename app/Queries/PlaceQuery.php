<?php

namespace App\Queries;

use App\Models\Place;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class PlaceQuery extends Query
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
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('name'),
            AllowedFilter::exact('featureCode', 'feature_code'),
            AllowedFilter::exact('countryCode', 'country_code'),
            AllowedFilter::exact('timeZoneCode', 'time_zone_code'),
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
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('country'),
            AllowedInclude::relationship('location'),
            AllowedInclude::relationship('alternateNames'),
            AllowedInclude::relationship('featureClass', 'feature_class'),
            AllowedInclude::relationship('featureCode', 'feature_code'),
            AllowedInclude::relationship('timeZone', 'time_zone'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('featureCode', 'feature_code'),
            AllowedSort::field('countryCode', 'country_code'),
            AllowedSort::field('timeZoneCode', 'time_zone_code'),
            AllowedSort::field('population'),
            AllowedSort::field('elevation'),
        ];
    }
}
