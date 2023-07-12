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
     *
     * @return string
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
     *     description="Filter languages by certain criteria",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum={"iso639.1", "iso639.2", "iso639.3"},
     *         @OA\Property(
     *             property="iso639.1",
     *             type="string",
     *             example="en"
     *         )
     *     )
     * )
     *
     * @return array
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
     *     parameter="languageSort",
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
     *                 "iso639.1",
     *                 "iso639.2",
     *                 "iso639.3",
     *                 "-name",
     *                 "-iso639.1",
     *                 "-iso639.2",
     *                 "-iso639.3",
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
            AllowedSort::field('name'),
            AllowedSort::field('iso639.1'),
            AllowedSort::field('iso639.2'),
            AllowedSort::field('iso639.3'),
        ];
    }
}
