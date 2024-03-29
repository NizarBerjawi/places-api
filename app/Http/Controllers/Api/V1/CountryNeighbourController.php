<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\CountryQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryNeighbourController extends Controller
{
    /**
     * Display the neighbouring countries of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      operationId="getCountryNeighbours",
     *      summary="Returns the neighbouring countries of a specific country.",
     *      path="/countries/{countryCode}/neighbours",
     *
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *      @OA\Parameter(ref="#/components/parameters/countryFilter"),
     *      @OA\Parameter(ref="#/components/parameters/countryInclude"),
     *      @OA\Parameter(ref="#/components/parameters/countrySort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                   property="data",
     *                   type="array",
     *
     *                   @OA\Items(ref="#/components/schemas/country")
     *              ),
     *
     *              @OA\Property(
     *                   property="links",
     *                   ref="#/components/schemas/collectionLinks",
     *              ),
     *              @OA\Property(
     *                   property="meta",
     *                   ref="#/components/schemas/collectionMeta",
     *              )
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          ref="#/components/responses/404"
     *      ),
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
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function index(CountryQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $countries = $query
            ->applyScope('neighbourOf', Arr::wrap($countryCode))
            ->getPaginator();

        return new PaginatedResourceResponse(
            CountryResource::collection($countries)
        );
    }
}
