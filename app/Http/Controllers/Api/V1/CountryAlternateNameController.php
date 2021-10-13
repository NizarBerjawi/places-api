<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AlternateNameResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\AlternateNameQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryAlternateNameController extends Controller
{
    /**
     * Display the alternate names of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the alternate names of a specific country",
     *      path="/countries/{countryCode}/alternateNames",
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameFilter"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameInclude"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/alternateName")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Alternate name not found"
     *       )
     * )
     *
     * @param  \App\Queries\CurrencyQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(AlternateNameQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $alternateNames = $query
            ->applyScope('byGeonameId', Arr::wrap(
                Country::find($countryCode)->geoname_id
            ))
            ->getPaginator();

        return new PaginatedResourceResponse(
            AlternateNameResource::collection($alternateNames)
        );
    }
}
