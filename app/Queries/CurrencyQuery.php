<?php

namespace App\Queries;

use App\Models\Currency;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class CurrencyQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
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
     *     description="Filter currencies by certain criteria",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum={"code", "name"},
     *         @OA\Property(
     *             property="code",
     *             type="string",
     *             example="AUD"
     *         )
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('code'),
            AllowedFilter::partial('name'),
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
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {"countries"},
     *         )
     *     )
     * )
     *
     * @return array
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
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {"code", "name", "-code", "-name"},
     *         )
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('code'),
            AllowedSort::field('name'),
        ];
    }
}
