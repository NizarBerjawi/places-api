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
     *      summary="Returns a list of paginated continents",
     *      path="/continents",
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/continent")
     *          ),
     *      ),
     *
     *      @OA\Parameter(ref="#/components/parameters/continentFilter"),
     *      @OA\Parameter(ref="#/components/parameters/continentInclude"),
     *      @OA\Parameter(ref="#/components/parameters/continentSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
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
     *     path="/continents/{continentCode}",
     *     operationId="getContinentByCode",
     *
     *     @OA\Property(ref="#/components/schemas/continent"),
     *
     *     @OA\Parameter(ref="#/components/parameters/continentCode"),
     *     @OA\Parameter(ref="#/components/parameters/continentInclude"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/continent")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Continent not found"
     *     ),
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
