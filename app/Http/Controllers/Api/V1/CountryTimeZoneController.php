<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TimeZoneResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\TimeZoneQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryTimeZoneController extends Controller
{
    /**
     * Display the Time Zones available in a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the Time Zones available in a specific country",
     *      path="/countries/{countryCode}/timeZones",
     *      @OA\Parameter(
     *         name="countryCode",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *                  "countryCode"
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
     *          description="Include related resources with time zone.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/timeZone")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       )
     * )
     *
     * @param  \App\Queries\TimeZoneQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $timeZones = $query
            ->applyScope('byCountry', Arr::wrap($countryCode))
            ->getPaginator();

        return new PaginatedResourceResponse(
            TimeZoneResource::collection($timeZones)
        );
    }
}
