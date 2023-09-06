<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\Currency;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class CurrencyQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return Currency::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="currencyFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter currencies by: `code` or `name`.",
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
     *                 type="string",
     *             )
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
     *     parameter="currencyInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="array",
     *
     *         @OA\Items(
     *             type="string",
     *             enum = {"countries"},
     *         )
     *     )
     * )
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('countries'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="currencySort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by certain properties.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="array",
     *
     *         @OA\Items(
     *             type="string",
     *             enum = {"code", "name", "-code", "-name"},
     *         )
     *     )
     * )
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('code'),
            AllowedSort::field('name'),
        ];
    }
}
