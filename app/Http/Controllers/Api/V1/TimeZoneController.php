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
     *      operationId="getTimeZones",
     *      path="/timeZones",
     *
     *      @OA\Parameter(ref="#/components/parameters/timeZoneFilter"),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneInclude"),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/timeZone")
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=429,
     *          ref="#/components/responses/429"
     *      ),
     *
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @OA\Tag(
     *     name="Time Zones",
     *     description="Everything about time zones"
     * )
     *
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
     *
     *     @OA\Parameter(ref="#/components/parameters/timeZoneCode"),
     *     @OA\Parameter(ref="#/components/parameters/timeZoneFilter"),
     *     @OA\Parameter(ref="#/components/parameters/timeZoneInclude"),
     *     @OA\Parameter(ref="#/components/parameters/timeZoneSort"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(ref="#/components/schemas/timeZone")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         ref="#/components/responses/404"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/401"
     *     ),
     *          *      @OA\Response(
     *          response=429,
     *          ref="#/components/responses/429"
     *      ),
     *
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @param  string  $code
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
