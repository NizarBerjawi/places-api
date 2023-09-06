<?php

namespace App\Queries;

use App\Filters\BooleanFilters;
use App\Filters\StringFilters;
use App\Models\AlternateName;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class AlternateNameQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return AlternateName::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="alternateNameFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter alternate names by: `name`, `isPreferredName`, `isShortName`, `isHistoric`, `isColloquial`, or `languageCode`",
     *     required=false,
     *     style="deepObject",
     *
     *     @OA\Schema(
     *         type="object",
     *
     *         @OA\Property(
     *             property="isPreferredName",
     *             type="object",
     *             @OA\Property(
     *                 property="eq",
     *                 type="boolean",
     *             )
     *         )
     *     )
     * )
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::custom('name', new StringFilters),
            AllowedFilter::custom('isPreferredName', new BooleanFilters, 'is_preferred_name'),
            AllowedFilter::custom('isShortName', new BooleanFilters, 'is_short_name'),
            AllowedFilter::custom('isHistoric', new BooleanFilters, 'is_historic'),
            AllowedFilter::custom('isColloquial', new BooleanFilters, 'is_colloquial'),
            AllowedFilter::custom('languageCode', new StringFilters, 'language_code'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @OA\Parameter(
     *     parameter="alternateNameInclude",
     *     name="include",
     *     in="query",
     *     description="Include resources related to the specified alternate name.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="array",
     *
     *         @OA\Items(
     *             type="string",
     *             enum = {
     *                 "language",
     *                 "place"
     *             },
     *         )
     *     )
     * )
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('language'),
            AllowedInclude::relationship('place'),
        ];
    }

    /**
     * The relations that we can sort by.
     *
     * @OA\Parameter(
     *     parameter="alternateNameSort",
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
     *             enum = {
     *                  "name",
     *                  "isPreferredName",
     *                  "isShortName",
     *                  "isHistoric",
     *                  "isColloquial",
     *                  "-name",
     *                  "-isPreferredName",
     *                  "-isShortName",
     *                  "-isHistoric",
     *                  "-isColloquial",
     *             },
     *         )
     *     )
     * )
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('isPreferredName', 'is_preferred_name'),
            AllowedSort::field('isShortName', 'is_short_name'),
            AllowedSort::field('isHistoric', 'is_historic'),
            AllowedSort::field('isColloquial', 'is_colloquial'),
            AllowedSort::field('languageCode', 'language_code'),
        ];
    }
}
