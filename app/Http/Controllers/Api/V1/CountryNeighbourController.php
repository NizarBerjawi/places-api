<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryNeighbourController extends Controller
{
    /**
     * Display the neighbouring countries of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the neighbouring countries of a specific country",
     *      path="/countries/{countryCode}/neighbours",
     *      @OA\Parameter(
     *         name="countryCode",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *              @OA\Items(ref="#/components/schemas/country")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter neighbouring countries by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={
     *                  "name",
     *                  "iso3166Alpha2",
     *                  "iso3166Alpha3",
     *                  "iso3166Numeric",
     *                  "population",
     *                  "area",
     *                  "phoneCode",
     *                  "areaGt",
     *                  "areaGte",
     *                  "areaLt",
     *                  "areaLte",
     *                  "areaBetween",
     *                  "populationGt",
     *                  "populationGte",
     *                  "populationLt",
     *                  "populationLte",
     *                  "populationBetween",
     *                  "neighbourOf"
     *              },
     *              @OA\Property(
     *                  property="areaLt",
     *                  type="integer",
     *                  example="100000"
     *              )
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include related resources with every neighbouring country.",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {
     *                      "continent",
     *                      "timeZones",
     *                      "flag",
     *                      "neighbours",
     *                      "languages"
     *                  },
     *              )
     *          )
     *      ),
     * )
     *
     * @param  \App\Filters\CountryFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $countries = $filter
            ->applyScope('neighbourOf', Arr::wrap($code))
            ->getPaginator();

        return new PaginatedResourceResponse(
            CountryResource::collection($countries)
        );
    }
}
