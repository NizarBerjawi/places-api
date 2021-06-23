<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;

class FlagController extends Controller
{
    /**
     * Display a listing of all flags.
     *
     * @OA\Get(
     *      tags={"Flags"},
     *      summary="Returns a list of paginated flags",
     *      path="/api/v1/flags",
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
     *              enum={"country_code"},
     *              @OA\Property(
     *                  property="country_code",
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
     * )
     * @OA\Tag(
     *     name="Flags",
     *     description="Everything about flags"
     * )
     *
     * @param \App\Filters\FlagFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(FlagFilter $filter)
    {
        $flags = $filter->getPaginator();

        return FlagResource::collection($flags);
    }

    /**
     * Display a specified flag.
     *
     * @OA\Get(
     *     tags={"Flags"},
     *     path="/api/v1/flags/{countryCode}",
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
     * @param \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FlagFilter $filter, string $code)
    {
        $flag = $filter
            ->getBuilder()
            ->where('country_code', $code)
            ->firstOrFail();

        return new FlagResource($flag);
    }
}
