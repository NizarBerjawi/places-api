<?php

namespace App\Queries;

use App\Models\AlternateName;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class AlternateNameQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
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
     *     description="Filter alternate names by certain criteria",
     *     required=false,
     *     explode=false,
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {"name", "isPreferredName", "isShortName", "languageCodes"},
     *         )
     *     )
     * )
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('name'),
            AllowedFilter::exact('isPreferredName', 'is_preferred_name'),
            AllowedFilter::exact('isShortName', 'is_short_name'),
            AllowedFilter::scope('languageCodes', 'byLanguageCode'),
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
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {"language"},
     *         )
     *     )
     * )
     *
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('language'),
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
     *     @OA\Schema(
     *         type="array",
     *         @OA\Items(
     *             type="string",
     *             enum = {
     *                  "name",
     *                  "isPreferredName",
     *                  "isShortName",
     *                  "-name",
     *                  "-isPreferredName",
     *                  "-isShortName"

     *             },
     *         )
     *     )
     * )
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('isPreferredName', 'is_preferred_name'),
            AllowedSort::field('isShortName', 'is_short_name'),
        ];
    }
}