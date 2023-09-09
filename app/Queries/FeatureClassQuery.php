<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\FeatureClass;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class FeatureClassQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return FeatureClass::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="featureClassFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter Feature Classes by: `code`.",
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
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="featureClassInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources with every Feature Class. Possible values: `featureCodes`.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="featureCodes"
     *     )
     * )
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('featureCodes'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="featureClassSort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by one or more properties: `code`.",
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
            AllowedSort::field('code'),
        ];
    }
}
