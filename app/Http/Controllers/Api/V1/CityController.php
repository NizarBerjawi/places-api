<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\PlaceQuery;
use Illuminate\Support\Arr;

class CityController extends Controller
{
    /**
     * Display a listing of all cities.
     *
     * @OA\Get(
     *      tags={"Cities"},
     *      operationId="getCities",
     *      summary="Returns a list of paginated cities.",
     *      path="/cities",
     *
     *      @OA\Parameter(ref="#/components/parameters/placeFilter"),
     *      @OA\Parameter(ref="#/components/parameters/placeInclude"),
     *      @OA\Parameter(ref="#/components/parameters/placeSort"),
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
     *                   @OA\Items(ref="#/components/schemas/place")
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
     *     name="Cities",
     *     description="Everything about cities"
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceQuery $query)
    {
        $places = $query
            ->applyScope('byCities')
            ->getPaginator();

        return new PaginatedResourceResponse(
            PlaceResource::collection($places)
        );
    }

    /**
     * Display a specified place.
     *
     * @OA\Get(
     *     tags={"Cities"},
     *     operationId="getCityDetails",
     *     summary="Returns the details of a specific city.",
     *     path="/cities/{geonameId}",
     *
     *     @OA\Property(ref="#/components/schemas/Place"),
     *
     *     @OA\Parameter(ref="#/components/parameters/placeFilter"),
     *     @OA\Parameter(ref="#/components/parameters/placeInclude"),
     *     @OA\Parameter(ref="#/components/parameters/placeSort"),
     *     @OA\Parameter(ref="#/components/parameters/geonameId"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/place"
     *             ),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         ref="#/components/responses/404"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/401"
     *     ),
     *          *      @OA\Response(
     *          response=429,
     *          ref="#/components/responses/429"
     *      ),
     *
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceQuery $query, $geonameId)
    {
        $place = $query
            ->applyScope('byCities')
            ->applyScope('byGeonameId', Arr::wrap($geonameId))
            ->getBuilder()
            ->firstOrFail();

        return PlaceResource::make($place);
    }
}
