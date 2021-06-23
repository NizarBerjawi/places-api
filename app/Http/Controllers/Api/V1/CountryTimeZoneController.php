<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TimeZoneResource;
use App\Models\Country;
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
     *      path="/api/v1/countries/{countryCode}/timeZones",
     *      @OA\Parameter(
     *         name="countryCode",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/time_zone")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       )
     * )
     *
     * @param  \App\Filters\TimeZoneFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $timeZones = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();

        return TimeZoneResource::collection($timeZones);
    }
}
