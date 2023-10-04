<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\PlaceQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryCityController extends Controller
{
    /**
     * Display the cities available in a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      operationId="getCountryCities",
     *      summary="Returns the cities available in a specific country.",
     *      path="/countries/{countryCode}/cities",
     *
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *      @OA\Parameter(ref="#/components/parameters/placeFilter"),
     *      @OA\Parameter(ref="#/components/parameters/placeInclude"),
     *      @OA\Parameter(ref="#/components/parameters/placeSort"),
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
     *                   @OA\Items(ref="#/components/schemas/place")
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
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $places = $query
            ->applyScope('byCountry', Arr::wrap($countryCode))
            ->applyScope('byCities')
            ->getPaginator();

        return new PaginatedResourceResponse(
            PlaceResource::collection($places)
        );
    }
}
