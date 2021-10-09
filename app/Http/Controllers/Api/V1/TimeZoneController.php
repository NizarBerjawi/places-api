<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TimeZoneResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\TimeZoneQuery;
use Illuminate\Support\Arr;

class TimeZoneController extends Controller
{
    /**
     * Display a listing of all time zones.
     *
     * @OA\Get(
     *      tags={"Time Zones"},
     *      summary="Returns a list of paginated time zones",
     *      path="/timeZones",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/timeZone")
     *          ),
     *      ),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneFilter"),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneInclude"),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneSort"),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Get a specific page",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *      ),
     * )
     * @OA\Tag(
     *     name="Time Zones",
     *     description="Everything about time zones"
     * )
     *
     * @param \App\Queries\TimeZoneQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneQuery $query)
    {
        $timeZones = $query->getPaginator();

        return new PaginatedResourceResponse(
            TimeZoneResource::collection($timeZones)
        );
    }

    /**
     * Display a specified time zone.
     *
     * @OA\Get(
     *     tags={"Time Zones"},
     *     path="/timeZones/{timeZoneCode}",
     *     operationId="getTimeZoneByCode",
     *     @OA\Parameter(ref="#/components/parameters/timeZoneCode"),
     *     @OA\Parameter(ref="#/components/parameters/timeZoneFilter"),
     *     @OA\Parameter(ref="#/components/parameters/timeZoneInclude"),
     *     @OA\Parameter(ref="#/components/parameters/timeZoneSort"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/timeZone")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Time zone not found"
     *     )
     * )
     * @param \App\Queries\TimeZoneQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(TimeZoneQuery $query, string $timeZoneCode)
    {
        $timeZone = $query
            ->applyScope('byTimeZoneCode', Arr::wrap($timeZoneCode))
            ->getBuilder()
            ->firstOrFail();

        return new TimeZoneResource($timeZone);
    }
}
