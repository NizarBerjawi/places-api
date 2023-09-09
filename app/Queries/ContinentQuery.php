<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\Continent;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class ContinentQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return Continent::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="continentFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter Continents by: `name` or `code`.",
     *     required=false,
     *     style="deepObject",

     *
     *     @OA\Schema(
     *         type="object",
     *
     *         @OA\Property(
     *             property="code",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="string"
     *             ),
     *         ),
     *         @OA\Property(
     *             property="name",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="string"
     *             ),
     *         )
     *     )
     * )
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('code', new StringFilters),
            AllowedFilter::custom('name', new StringFilters),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="continentInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources with every Continent. Possible values: `countries` and `alternateNames`.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="countries"
     *     )
     * )
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('countries'),
            AllowedInclude::relationship('alternateNames'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="continentSort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by one or more properties: `name` and `code`.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="-code"
     *     )
     * )
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('code'),
        ];
    }
}
