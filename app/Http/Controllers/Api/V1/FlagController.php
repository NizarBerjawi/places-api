<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\FlagQuery;

class FlagController extends Controller
{
    /**
     * Display a listing of all flags.
     *
     * @OA\Get(
     *      tags={"Flags"},
     *      summary="Returns a list of paginated flags",
     *      path="/flags",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/flag")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter flags by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={"countryCode"},
     *              @OA\Property(
     *                  property="countryCode",
     *                  type="string",
     *                  example="AU"
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
     *                  enum = {"country"},
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
     * @OA\Tag(
     *     name="Flags",
     *     description="Everything about flags"
     * )
     *
     * @param \App\Queries\FlagQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(FlagQuery $query)
    {
        $flags = $query->getPaginator();

        return new PaginatedResourceResponse(
            FlagResource::collection($flags)
        );
    }

    /**
     * Display a specified flag.
     *
     * @OA\Get(
     *     tags={"Flags"},
     *     path="/flags/{countryCode}",
     *     operationId="getFlagByCode",
     *     @OA\Property(ref="#/components/schemas/flag"),
     *     @OA\Parameter(
     *        name="countryCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/flag")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Flag not found"
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
     *                  enum = {"country"},
     *              )
     *          )
     *      ),
     * )
     * @param \App\Queries\FlagQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FlagQuery $query, string $code)
    {
        $flag = $query
            ->getBuilder()
            ->where('country_code', $code)
            ->firstOrFail();

        return new FlagResource($flag);
    }
}
