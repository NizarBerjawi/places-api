<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceResource;
use App\Models\Country;
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
     *      path="/api/v1/countries/{countryCode}/places",
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
     *                  "feature_code",
     *                  "country_code",
     *                  "population_gt",
     *                  "population_gte",
     *                  "population_lt",
     *                  "population_lte",
     *                  "population_between"
     *              },
     *              @OA\Property(
     *                  property="population_gt",
     *                  type="integer",
     *                  example="100000"
     *              )
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

        return PlaceResource::collection($places);
    }
}
