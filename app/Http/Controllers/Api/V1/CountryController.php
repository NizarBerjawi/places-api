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
     *      @OA\Parameter(ref="#/components/parameters/countryFilter"),
     *      @OA\Parameter(ref="#/components/parameters/countryInclude"),
     *      @OA\Parameter(ref="#/components/parameters/countrySort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/country")
     *          ),
     *      )
     * )
     *
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
     *     @OA\Parameter(ref="#/components/parameters/countryCode"),
     *     @OA\Parameter(ref="#/components/parameters/countryInclude"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/country")
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *      )
     * )
     *
     * @param  \App\Queries\CountryQuery  $query
     * @param  string  $countryCode
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
