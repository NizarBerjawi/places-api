<?php

namespace App\Filters;

use App\Models\Country;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CountryFilter implements Filter
{
    /**
     * The attributes we can use to filter countries
     *
     * @var array
     */
    public function getAllowedFilters()
    {
        return [
            AllowedFilter::partial('name'),
            AllowedFilter::exact('iso3166_alpha2'),
            AllowedFilter::exact('iso3166_alpha3'),
            AllowedFilter::exact('iso3166_numeric'),
            AllowedFilter::exact('population'),
            AllowedFilter::exact('area'),
            AllowedFilter::exact('phone_code'),
            AllowedFilter::scope('area_gt'),
            AllowedFilter::scope('area_gte'),
            AllowedFilter::scope('area_lt'),
            AllowedFilter::scope('area_lte'),
            AllowedFilter::scope('area_between'),
            AllowedFilter::scope('population_gt'),
            AllowedFilter::scope('population_gte'),
            AllowedFilter::scope('population_lt'),
            AllowedFilter::scope('population_lte'),
            AllowedFilter::scope('population_between'),
        ];
    }

    /**
     * The query builder used to apply the filters
     *
     * @return \Spatie\QueryBuilder\QueryBuilder
     */
    public function getBuilder()
    {
        return QueryBuilder::for(Country::class)
            ->allowedFilters($this->getAllowedFilters());
    }
}
