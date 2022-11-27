<?php

namespace App\Queries;

use App\Filters\NumericFilters;
use App\Filters\StringFilters;
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
     * @OA\Parameter(
     *     parameter="placeFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter places by certain criteria",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum={
     *             "name",
     *             "featureCode",
     *             "countryCode",
     *             "elevation",
     *             "elevationGt",
     *             "elevationGte",
     *             "elevationLt",
     *             "elevationLte",
     *             "population",
     *             "populationGt",
     *             "populationGte",
     *             "populationLt",
     *             "populationLte"
     *         },
     *         @OA\Property(
     *             property="populationGt",
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
            AllowedFilter::custom('name', new StringFilters),
            AllowedFilter::custom('featureCode', new StringFilters, 'feature_code'),
            AllowedFilter::custom('countryCode', new StringFilters, 'country_code'),
            AllowedFilter::custom('timeZoneCode', new StringFilters, 'time_zone_code'),
            AllowedFilter::custom('elevation', new NumericFilters),
            AllowedFilter::custom('population', new NumericFilters),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="placeInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources",
     *     required=false,
     *     explode=false,
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {
     *                  "country",
     *                  "location",
     *                  "alternateNames",
     *                  "featureClass",
     *                  "featureCode",
     *                  "timeZone",
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
            AllowedInclude::relationship('country'),
            AllowedInclude::relationship('location'),
            AllowedInclude::relationship('alternateNames'),
            AllowedInclude::relationship('featureClass'),
            AllowedInclude::relationship('featureCode'),
            AllowedInclude::relationship('timeZone'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="placeSort",
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
     *                 "featureCode",
     *                 "countryCode",
     *                 "timeZoneCode",
     *                 "population",
     *                 "elevation",
     *                 "-name",
     *                 "-featureCode",
     *                 "-countryCode",
     *                 "-timeZoneCode",
     *                 "-population",
     *                 "-elevation"
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
            AllowedSort::field('name', 'ascii_name'),
            AllowedSort::field('featureCode', 'feature_code'),
            AllowedSort::field('countryCode', 'country_code'),
            AllowedSort::field('timeZoneCode', 'time_zone_code'),
            AllowedSort::field('population'),
            AllowedSort::field('elevation'),
        ];
    }
}
