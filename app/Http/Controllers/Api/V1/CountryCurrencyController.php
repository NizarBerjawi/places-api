<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CurrencyResource;
use App\Models\Country;
use App\Queries\CurrencyQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryCurrencyController extends Controller
{
    /**
     * Display the currency of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the currency of a specific country",
     *      path="/countries/{countryCode}/currency",
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *      @OA\Parameter(ref="#/components/parameters/currencyFilter"),
     *      @OA\Parameter(ref="#/components/parameters/currencyInclude"),
     *      @OA\Parameter(ref="#/components/parameters/currencySort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/currency")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       )
     * )
     *
     * @param  \App\Queries\CurrencyQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $currency = $query
            ->applyScope('byCountry', Arr::wrap($countryCode))
            ->getBuilder()
            ->firstOrFail();

        return CurrencyResource::make($currency);
    }
}
