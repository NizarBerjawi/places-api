<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\FeatureCode;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class FeatureCodeQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return FeatureCode::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="featureCodeFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter feature codes by: `code` or `featureClassCode`.",
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
            AllowedFilter::custom('featureClassCode', new StringFilters, 'feature_class_code'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="featureCodeInclude",
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
     *             enum = {"featureClass"},
     *         )
     *     )
     * )
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('featureClass'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="featureCodeSort",
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
     *             enum = {"code", "-code"},
     *         )
     *     )
     * )
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('code'),
        ];
    }
}
