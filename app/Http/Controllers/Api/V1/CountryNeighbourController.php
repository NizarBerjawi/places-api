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
     *      summary="Returns the neighbouring countries of a specific country",
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
     *          description="Successful operation",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/country")
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *      )
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
