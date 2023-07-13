<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CurrencyResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\CurrencyQuery;
use Illuminate\Support\Arr;

class CurrencyController extends Controller
{
    /**
     * Display a listing of all currencies.
     *
     * @OA\Get(
     *      tags={"Currencies"},
     *      summary="Returns a list of paginated currencies",
     *      path="/currencies",
     *
     *      @OA\Parameter(ref="#/components/parameters/currencyFilter"),
     *      @OA\Parameter(ref="#/components/parameters/currencyInclude"),
     *      @OA\Parameter(ref="#/components/parameters/currencySort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/currency")
     *          ),
     *      ),
     * )
     *
     * @OA\Tag(
     *     name="Currencies",
     *     description="Everything about currencies"
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyQuery $query)
    {
        $currencies = $query->getPaginator();

        return new PaginatedResourceResponse(
            CurrencyResource::collection($currencies)
        );
    }

    /**
     * Display a specified currency.
     *
     * @OA\Get(
     *     tags={"Currencies"},
     *     path="/currencies/{currencyCode}",
     *     operationId="getCurrencyByCode",
     *
     *     @OA\Parameter(ref="#/components/parameters/currencyCode"),
     *     @OA\Parameter(ref="#/components/parameters/currencyInclude"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/currency")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Currency not found"
     *     )
     * )
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show(CurrencyQuery $query, string $currencyCode)
    {
        $currency = $query
            ->applyScope('byCurrencyCode', Arr::wrap($currencyCode))
            ->getBuilder()
            ->firstOrFail();

        return new CurrencyResource($currency);
    }
}
