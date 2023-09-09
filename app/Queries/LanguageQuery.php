<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\Language;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class LanguageQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return Language::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="languageFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter languages by: `iso639.1`, `iso639.2`, or `iso639.3`",
     *     required=false,
     *     style="deepObject",
     *
     *     @OA\Schema(
     *         type="object",
     *
     *         @OA\Property(
     *             property="iso639.1",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="string"
     *             ),
     *         ),
     *         @OA\Property(
     *             property="iso639.2",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="string"
     *             ),
     *         ),
     *         @OA\Property(
     *             property="iso639.3",
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
            AllowedFilter::custom('iso639.1', new StringFilters, 'iso639_1'),
            AllowedFilter::custom('iso639.2', new StringFilters, 'iso639_2'),
            AllowedFilter::custom('iso639.3', new StringFilters, 'iso639_3'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="languageInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources with every Language. Possible values: `countries`.",
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
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="languageSort",
     *     name="sort",
     *     in="query",
     *     description="Sort the result set by one or more properties:`name`,`iso639.1`,`iso639.2`, and `iso639.3`.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="-iso639.1"
     *     )
     * )
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('iso639.1'),
            AllowedSort::field('iso639.2'),
            AllowedSort::field('iso639.3'),
        ];
    }
}
