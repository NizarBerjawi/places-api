<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ContinentResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\ContinentQuery;
use Illuminate\Support\Arr;

class ContinentController extends Controller
{
    /**
     * Display a listing of all continents.
     *
     * @OA\Get(
     *      tags={"Continents"},
     *      operationId="getContinents",
     *      summary="Returns a list of paginated continents.",
     *      path="/continents",
     *
     *      @OA\Parameter(ref="#/components/parameters/continentFilter"),
     *      @OA\Parameter(ref="#/components/parameters/continentInclude"),
     *      @OA\Parameter(ref="#/components/parameters/continentSort"),
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
     *                   @OA\Items(ref="#/components/schemas/continent")
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
     *          ),
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
     *     name="Continents",
     *     description="Everything about continents"
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContinentQuery $query)
    {
        $continents = $query->getPaginator();

        return new PaginatedResourceResponse(
            ContinentResource::collection($continents)
        );
    }

    /**
     * Display a specified continent.
     *
     * @OA\Get(
     *     tags={"Continents"},
     *     operationId="getContinentDetails",
     *     summary="Returns the details of a specified continent.",
     *     path="/continents/{continentCode}",
     *
     *     @OA\Property(ref="#/components/schemas/continent"),
     *
     *     @OA\Parameter(ref="#/components/parameters/continentCode"),
     *     @OA\Parameter(ref="#/components/parameters/continentInclude"),
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
     *                   ref="#/components/schemas/continent"
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
     * @return \Illuminate\Http\Response
     */
    public function show(ContinentQuery $query, string $continentCode)
    {
        $continent = $query
            ->applyScope('byCode', Arr::wrap($continentCode))
            ->getBuilder()
            ->firstOrFail();

        return new ContinentResource($continent);
    }
}
