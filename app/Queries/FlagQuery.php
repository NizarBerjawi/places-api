<?php

namespace App\Queries;

use App\Models\Flag;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class FlagQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
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
     *     description="Sort the result set by certain properties.",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum = {"countryCode"},
     *         @OA\Property(
     *             property="countryCode",
     *             type="string",
     *             example="AU"
     *         )
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('countryCode', 'country_code'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="flagInclude",
     *     name="include",
     *     in="query",
     *     description="Include resources related to the specified flag.",
     *     required=false,
     *     explode=false,
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {"country"},
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
        ];
    }

    /**
     * The relations that we can sort by.

     * @OA\Parameter(
     *     parameter="flagSort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by certain properties.",
     *     required=false,
     *     explode=false,
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {"countryCode", "-countryCode"},
     *         )
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('countryCode', 'country_code'),
        ];
    }
}
