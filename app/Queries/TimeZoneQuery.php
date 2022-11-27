<?php

namespace App\Queries;

use App\Filters\StringFilters;
use App\Models\TimeZone;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class TimeZoneQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return TimeZone::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @OA\Parameter(
     *     parameter="timeZoneFilter",
     *     name="filter",
     *     in="query",
     *     description="Filter time zones by certain criteria",
     *     required=false,
     *     style="deepObject",
     *     @OA\Schema(
     *         type="object",
     *         enum={
     *             "code"
     *         },
     *         @OA\Property(
     *             property="code",
     *             type="string",
     *             example="asia_tokyo"
     *         )
     *     )
     * )
     *
     * @return array
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
     *     parameter="timeZoneInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources",
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
     *
     * @OA\Parameter(
     *     parameter="timeZoneSort",
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
     *                 "gmtOffset",
     *                 "code",
     *                 "timeZone",
     *                 "-gmtOffset",
     *                 "-code",
     *                 "-timeZone"

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
            AllowedSort::field('gmtOffset', 'gmt_offset'),
            AllowedSort::field('code'),
            AllowedSort::field('timeZone', 'time_zone'),
        ];
    }
}
