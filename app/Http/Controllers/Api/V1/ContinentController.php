<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\ContinentFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ContinentResource;

class ContinentController extends Controller
{
    /**
     * Display a listing of all continents.
     *
     * @OA\Get(
     *      tags={"Continents"},
     *      summary="Returns a list of paginated continents",
     *      path="/continents",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/continent")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter continents by name or continent code",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={"code", "name"},
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  example="OC"
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Oceania"
     *              ),
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
     *      ),
     * )
     * @OA\Tag(
     *     name="Continents",
     *     description="Everything about continents"
     * )
     *
     * @param \App\Filters\ContinentFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(ContinentFilter $filter)
    {
        $continents = $filter->getPaginator();

        return ContinentResource::collection($continents);
    }

    /**
     * Display a specified continent.
     *
     * @OA\Get(
     *     tags={"Continents"},
     *     path="/continents/{continentCode}",
     *     operationId="getContinentByCode",
     *     @OA\Property(ref="#/components/schemas/continent"),
     *     @OA\Parameter(
     *        name="continentCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/continent")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Continent not found"
     *       ),
     * )
     * @param \App\Filters\ContinentFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(ContinentFilter $filter, string $code)
    {
        $continent = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new ContinentResource($continent);
    }
}
