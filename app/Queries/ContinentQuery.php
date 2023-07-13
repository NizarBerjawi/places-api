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
     *     description="Filter continents by name or code",
     *     required=false,
     *     style="deepObject",
     *
     *     @OA\Schema(
     *         type="object",
     *         enum={"code", "name"},
     *
     *         @OA\Property(
     *             property="code",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="string",
     *                 example="EU"
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
     *     parameter="continentInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources with every continent.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="array",
     *
     *         @OA\Items(
     *             type="string",
     *             enum = {"countries", "alternateNames"},
     *         )
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
     *     description="Sort the result set by certain properties.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="array",
     *
     *         @OA\Items(
     *             type="string",
     *             enum = {"name", "code", "-name", "-code"},
     *         )
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
