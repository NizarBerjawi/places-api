<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;
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
     *      path="/api/v1/countries/{countryCode}/neighbours",
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
     *              @OA\Items(ref="#/components/schemas/country")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       )
     * )
     *
     * @param  \App\Filters\CountryFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $countries = $filter
            ->applyScope('neighbourOf', Arr::wrap($code))
            ->getPaginator();

        return CountryResource::collection($countries);
    }
}
