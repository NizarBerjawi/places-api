<?php

namespace App\Queries;

use App\Models\Place;
use Spatie\QueryBuilder\AllowedFilter;

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
            'country',
            'location',
            'featureClass',
            'featureCode',
            'timeZone',
        ];
    }

    public function getAllowedSorts(): array
    {
        return [
            'name',
            'feature_code',
            'country_code',
            'time_zone_code',
            'population',
            'elevation',
        ];
    }
}
