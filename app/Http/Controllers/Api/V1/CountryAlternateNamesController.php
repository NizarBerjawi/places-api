<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AlternateNameResource;
use App\Models\Country;
use App\Queries\AlternateNameQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryAlternateNamesController extends Controller
{
    /**
     * Display the alternate names of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the alternate names of a specific country",
     *      path="/countries/{countryCode}/alternateNames",
     *      @OA\Parameter(
     *         name="countryCode",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *          description="Country not found"
     *       ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include resources related to the specified alternate name.",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"place", "country", "language"},
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

        return AlternateNameResource::collection($alternateNames);
    }
}
