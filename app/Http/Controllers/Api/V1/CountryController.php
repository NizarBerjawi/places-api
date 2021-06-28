<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;

class CountryController extends Controller
{
    /**
     * Display a listing of all countries.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns a list of paginated countries",
     *      path="/api/v1/countries",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/country")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter countries by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={
     *                  "name",
     *                  "iso3166_alpha2",
     *                  "iso3166_alpha3",
     *                  "iso3166_numeric",
     *                  "population",
     *                  "area",
     *                  "phone_code",
     *                  "area_gt",
     *                  "area_gte",
     *                  "area_lt",
     *                  "area_lte",
     *                  "area_between",
     *                  "population_gt",
     *                  "population_gte",
     *                  "population_lt",
     *                  "population_lte",
     *                  "population_between",
     *                  "neighbour_of"
     *              },
     *              @OA\Property(
     *                  property="area_lt",
     *                  type="integer",
     *                  example="100000"
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
     *                  enum = {"continent", "timeZones", "flag", "neighbours"},
     *              )
     *          )
     *      ),
     * )
     * @OA\Tag(
     *     name="Countries",
     *     description="Everything about countries"
     * )
     *
     * @param  \App\Filters\CountryFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter)
    {
        $countries = $filter->getPaginator();

        return CountryResource::collection($countries);
    }

    /**
     * Display a specified country.
     *
     * @OA\Get(
     *     tags={"Countries"},
     *     path="/api/v1/countries/{countryCode}",
     *     operationId="getCountryByCode",
     *     @OA\Property(ref="#/components/schemas/country"),
     *     @OA\Parameter(
     *        name="countryCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/country")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
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
     *                  enum = {"continent", "timeZones", "flag", "neighbours"},
     *              )
     *          )
     *      ),
     * )
     * @param  \App\Filters\CountryFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(CountryFilter $filter, string $code)
    {
        $country = $filter
            ->getBuilder()
            ->where('iso3166_alpha2', $code)
            ->firstOrFail();

        return new CountryResource($country);
    }
}
