<?php

namespace App\Filters;

use App\Models\TimeZone;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class TimeZoneFilter extends Filter
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return TimeZone::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @return array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('code'),
            AllowedFilter::scope('countryCode', 'by_country'),
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
            AllowedInclude::relationship('country'),
        ];
    }
}
