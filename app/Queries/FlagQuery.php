<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\Flag;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class FlagQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return Flag::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="flagFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter flags by: `countryCode`.",
     *     required=false,
     *     style="deepObject",
     *
     *     @OA\Schema(
     *         type="object",
     *
     *         @OA\Property(
     *             property="countryCode",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="string",
     *             )
     *         )
     *     )
     * )
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('countryCode', new StringFilters, 'country_code'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="flagInclude",
     *     name="include",
     *     in="query",
     *     description="Include resources related to the specified flag. Possible values: `country`",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="countrys"
     *     )
     * )
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('country'),
        ];
    }

    /**
     * The relations that we can sort by.

     *
     * @OA\Parameter(
     *     parameter="flagSort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by one or more properties: `countryCode`",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="countryCode"
     *     )
     * )
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('countryCode', 'country_code'),
        ];
    }
}
