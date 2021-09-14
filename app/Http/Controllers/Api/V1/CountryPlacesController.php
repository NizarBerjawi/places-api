<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryPlacesController extends Controller
{
    /**
     * Display the places available in a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the places available in a specific country",
     *      path="/countries/{countryCode}/places",
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
     *          description="Filter places by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={
     *                  "featureCode",
     *                  "countryCode",
     *                  "elevation",
     *                  "elevationGt",
     *                  "elevationGte",
     *                  "elevationLt",
     *                  "elevationLte",
     *                  "elevationBetween",
     *                  "population",
     *                  "populationGt",
     *                  "populationGte",
     *                  "populationLt",
     *                  "populationLte",
     *                  "populationBetween"
     *              },
     *              @OA\Property(
     *                  property="populationGt",
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
     *                  enum = {"country", "location", "featureClass", "featureCode", "timeZone"},
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
     *              @OA\Items(ref="#/components/schemas/place")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       )
     * )
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $places = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();

        return new PaginatedResourceResponse(
            PlaceResource::collection($places)
        );
    }
}
