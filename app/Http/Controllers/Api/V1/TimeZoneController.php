<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TimeZoneResource;

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
     *              @OA\Items(ref="#/components/schemas/time_zone")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter time zones by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={
     *                  "code",
     *                  "country_code"
     *              },
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  example="asia_tokyo"
     *              )
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include related resources",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"country"},
     *              )
     *          )
     *      ),
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
     * @param \App\Filters\TimeZoneFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneFilter $filter)
    {
        $timeZones = $filter->getPaginator();

        return TimeZoneResource::collection($timeZones);
    }

    /**
     * Display a specified time zone.
     *
     * @OA\Get(
     *     tags={"Time Zones"},
     *     path="/timeZones/{timeZoneCode}",
     *     operationId="getTimeZoneByCode",
     *     @OA\Property(ref="#/components/schemas/time_zone"),
     *     @OA\Parameter(
     *        name="timeZoneCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/time_zone")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Time zone not found"
     *       ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include related resources",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"country"},
     *              )
     *          )
     *      ),
     * )
     * @param \App\Filters\TimeZoneFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(TimeZoneFilter $filter, string $code)
    {
        $timeZone = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new TimeZoneResource($timeZone);
    }
}
