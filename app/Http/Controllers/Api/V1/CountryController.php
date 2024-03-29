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
     *      operationId="getCountries",
     *      summary="Returns a list of paginated countries.",
     *      path="/countries",
     *
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
     * @OA\Tag(
     *     name="Countries",
     *     description="Everything about countries"
     * )
     *
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
     *     operationId="getCountryDetails",
     *     summary="Returns the details of a specific country.",
     *     path="/countries/{countryCode}",
     *
     *     @OA\Parameter(ref="#/components/parameters/countryCode"),
     *     @OA\Parameter(ref="#/components/parameters/countryInclude"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                   property="data",
     *                   type="object",
     *                   ref="#/components/schemas/country"
     *              ),
     *          ),
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
    public function show(CountryQuery $query, string $countryCode)
    {
        $country = $query
            ->applyScope('byCountryCode', Arr::wrap($countryCode))
            ->getBuilder()
            ->firstOrFail();

        return new CountryResource($country);
    }
}
