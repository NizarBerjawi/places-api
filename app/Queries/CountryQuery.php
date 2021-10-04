<?php

namespace App\Queries;

use App\Models\Country;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

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
     * @OA\Parameter(
     *     parameter="countryFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter countries by certain criteria",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum={
     *             "name",
     *             "iso3166Alpha2",
     *             "iso3166Alpha3",
     *             "iso3166Numeric",
     *             "population",
     *             "area",
     *             "phoneCode",
     *             "areaGt",
     *             "areaGte",
     *             "areaLt",
     *             "areaLte",
     *             "areaBetween",
     *             "populationGt",
     *             "populationGte",
     *             "populationLt",
     *             "populationLte",
     *             "populationBetween",
     *             "neighbourOf"
     *         },
     *         @OA\Property(
     *             property="areaLt",
     *             type="integer",
     *             example="100000"
     *         )
     *     )
     * )
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
     * @OA\Parameter(
     *     parameter="countryInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources with every country.",
     *     required=false,
     *     explode=false,
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {
     *                 "continent",
     *                 "timeZones",
     *                 "flag",
     *                 "neighbours",
     *                 "languages",
     *                 "currency",
     *                 "alternateNames"
     *             },
     *         )
     *     )
     * )
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
            AllowedInclude::relationship('alternateNames'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="countrySort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by certain properties.",
     *     required=false,
     *     explode=false,
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {
     *                 "name",
     *                 "iso3166Alpha2",
     *                 "iso3166Alpha3",
     *                 "iso3166Numeric",
     *                 "population",
     *                 "area",
     *                 "phoneCode"
     *             },
     *         )
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('iso3166Alpha2', 'iso3166_alpha2'),
            AllowedSort::field('iso3166Alpha3', 'iso3166_alpha3'),
            AllowedSort::field('iso3166Numeric', 'iso3166_numeric'),
            AllowedSort::field('population'),
            AllowedSort::field('area'),
            AllowedSort::field('phoneCode', 'phone_code'),
        ];
    }
}
