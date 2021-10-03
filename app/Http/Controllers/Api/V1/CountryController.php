<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\CountryQuery;
use Illuminate\Support\Arr;

class CountryController extends Controller
{
    /**
     * Display a listing of all countries.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns a list of paginated countries",
     *      path="/countries",
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
     *          description="Include related resources with every country.",
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
     *                      "languages",
     *                      "currency"
     *                  },
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
     *     name="Countries",
     *     description="Everything about countries"
     * )
     *
     * @param  \App\Queries\CountryQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(CountryQuery $query)
    {
        $countries = $query->getPaginator();

        return new PaginatedResourceResponse(
            CountryResource::collection($countries)
        );
    }

    /**
     * Display a specified country.
     *
     * @OA\Get(
     *     tags={"Countries"},
     *     path="/countries/{countryCode}",
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
     *          description="Include resources related to the specified country.",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"continent", "timeZones", "flag", "neighbours", "languages"},
     *              )
     *          )
     *      ),
     * )
     * @param  \App\Queries\CountryQuery  $query
     * @param  string $countryCode
     * @return \Illuminate\Http\Response
     */
    public function show(CountryQuery $query, string $countryCode)
    {
        $country = $query
            ->applyScope('byCountryCode', Arr::wrap($countryCode))
            ->getBuilder()
            ->firstOrFail();

        return new CountryResource($country);
    }
}
