<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CurrencyFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CurrencyResource;
use App\Models\Country;
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
     *      path="/api/v1/countries/{countryCode}/currency",
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
     *              @OA\Items(ref="#/components/schemas/currency")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include related resources",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"countries"},
     *              )
     *          )
     *      ),
     * )
     *
     * @param  \App\Filters\CurrencyFilter $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $currency = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getBuilder()
            ->first();

        return CurrencyResource::make($currency);
    }
}
