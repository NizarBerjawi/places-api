<?php

namespace App\Queries;

use App\Models\Country;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class CountryQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return Country::class;
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
            AllowedFilter::exact('iso3166Alpha2', 'iso3166_alpha2'),
            AllowedFilter::exact('iso3166Alpha3', 'iso3166_alpha3'),
            AllowedFilter::exact('iso3166Numeric', 'iso3166_numeric'),
            AllowedFilter::exact('population'),
            AllowedFilter::exact('area'),
            AllowedFilter::exact('phoneCode', 'phone_code'),
            AllowedFilter::scope('areaGt'),
            AllowedFilter::scope('areaGte'),
            AllowedFilter::scope('areaLt'),
            AllowedFilter::scope('areaLte'),
            AllowedFilter::scope('areaBetween'),
            AllowedFilter::scope('populationGt'),
            AllowedFilter::scope('populationGte'),
            AllowedFilter::scope('populationLt'),
            AllowedFilter::scope('populationLte'),
            AllowedFilter::scope('populationBetween'),
            AllowedFilter::scope('neighbourOf'),
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
            AllowedInclude::relationship('continent'),
            AllowedInclude::relationship('timeZones'),
            AllowedInclude::relationship('flag'),
            AllowedInclude::relationship('neighbours'),
            AllowedInclude::relationship('languages'),
            AllowedInclude::relationship('currency'),
        ];
    }

    public function getAllowedSorts(): array
    {
        return [
            'name',
            'iso3166Alpha2',
            'iso3166Alpha3',
            'iso3166Numeric',
            'population',
            'area',
            'phoneCode',
        ];
    }
}
