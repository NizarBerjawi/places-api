<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CurrencyFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CurrencyResource;
use App\Pagination\PaginatedResourceResponse;

class CurrencyController extends Controller
{
    /**
     * Display a listing of all currencies.
     *
     * @OA\Get(
     *      tags={"Currencies"},
     *      summary="Returns a list of paginated currencies",
     *      path="/currencies",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/currency")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter currencies by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={"code", "name"},
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  example="AUD"
     *              )
     *          )
     *      ),
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
     *      )
     * )
     * @OA\Tag(
     *     name="Currencies",
     *     description="Everything about currencies"
     * )
     *
     * @param  \App\Filters\CurrencyFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyFilter $filter)
    {
        $currencies = $filter->getPaginator();

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
     *     @OA\Property(ref="#/components/schemas/currency"),
     *     @OA\Parameter(
     *        name="currencyCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/currency")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Currency not found"
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
     * @param  \App\Filters\CurrencyFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(CurrencyFilter $filter, string $code)
    {
        $currency = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new CurrencyResource($currency);
    }
}
