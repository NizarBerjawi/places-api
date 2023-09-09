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
     *      summary="Returns a list of paginated currencies.",
     *      operationId="getCurrencies",
     *      path="/currencies",
     *
     *      @OA\Parameter(ref="#/components/parameters/currencyFilter"),
     *      @OA\Parameter(ref="#/components/parameters/currencyInclude"),
     *      @OA\Parameter(ref="#/components/parameters/currencySort"),
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
     *                   @OA\Items(ref="#/components/schemas/currency")
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
     *     summary="Returns the details of a specific currency.",
     *     operationId="getCurrencyDetails",
     *
     *     @OA\Parameter(ref="#/components/parameters/currencyCode"),
     *     @OA\Parameter(ref="#/components/parameters/currencyInclude"),
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
     *                   ref="#/components/schemas/currency"
     *              ),
     *          ),
     *     ),
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
