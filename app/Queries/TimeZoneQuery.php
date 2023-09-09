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
     *     description="Filter Time Zones by: `code`.",
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
     *                 type="string"
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
     *     parameter="timeZoneInclude",
     *     name="include",
     *     in="query",
     *     description="Include related resources with every Time Zone. Possible values: `country`.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="country"
     *     )
     * )
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
     *     description="Sort the result set by one or more properties: `gmtOffset`,`code`, and `timeZone`.",
     *     required=false,
     *     explode=false,
     *
     *     @OA\Schema(
     *         type="string",
     *         format="csv",
     *         example="code"
     *     )
     * )
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
