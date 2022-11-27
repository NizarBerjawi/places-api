<?php

namespace App\Queries;

use App\Filters\NumericFilters;
use App\Filters\StringFilters;
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
     *             "phoneCode"
     *         },
     *         @OA\Property(
     *             property="area",
     *             type="object",
     *             @OA\Property(
     *                 property="lt",
     *                 type="integer",
     *                 example=10000
     *             )
     *         ),
     *         @OA\Property(
     *             property="population",
     *             type="object",
     *             @OA\Property(
     *                 property="gt",
     *                 type="integer",
     *                 example=5000000
     *             )
     *         ),
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('name', new StringFilters),
            AllowedFilter::custom('iso3166Alpha2', new StringFilters, 'iso3166_alpha2'),
            AllowedFilter::custom('iso3166Alpha3', new StringFilters, 'iso3166_alpha3'),
            AllowedFilter::custom('iso3166Numeric', new NumericFilters, 'iso3166_numeric'),
            AllowedFilter::custom('population', new NumericFilters),
            AllowedFilter::custom('area', new NumericFilters),
            AllowedFilter::custom('phoneCode', new StringFilters, 'phone_code'),
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
     *                 "alternateNames",
     *                 "location"
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
            AllowedInclude::relationship('location'),
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
     *                 "phoneCode",
     *                 "-name",
     *                 "-iso3166Alpha2",
     *                 "-iso3166Alpha3",
     *                 "-iso3166Numeric",
     *                 "-population",
     *                 "-area",
     *                 "-phoneCode"
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
