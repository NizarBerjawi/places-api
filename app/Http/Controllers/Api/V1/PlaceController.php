<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\PlaceQuery;
use Illuminate\Support\Arr;

class PlaceController extends Controller
{
    /**
     * Display a listing of all places.
     *
     * @OA\Get(
     *      tags={"Places"},
     *      summary="Returns a list of paginated places",
     *      path="/places",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/place")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter places by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={
     *                  "featureCode",
     *                  "countryCode",
     *                  "elevation",
     *                  "elevationGt",
     *                  "elevationGte",
     *                  "elevationLt",
     *                  "elevationLte",
     *                  "elevationBetween",
     *                  "population",
     *                  "populationGt",
     *                  "populationGte",
     *                  "populationLt",
     *                  "populationLte",
     *                  "populationBetween"
     *              },
     *              @OA\Property(
     *                  property="populationGt",
     *                  type="integer",
     *                  example="100000"
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
     *                  enum = {"country", "location", "featureClass", "featureCode", "timeZone"},
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
     *     name="Places",
     *     description="Everything about places"
     * )
     *
     * @param \App\Queries\PlaceQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceQuery $query)
    {
        $places = $query->getPaginator();

        return new PaginatedResourceResponse(
            PlaceResource::collection($places)
        );
    }

    /**
     * Display a specified place.
     *
     * @OA\Get(
     *     tags={"Places"},
     *     path="/places/{geonameId}",
     *     operationId="getPlaceByGeonameId",
     *     @OA\Property(ref="#/components/schemas/Place"),
     *     @OA\Parameter(
     *        name="geonameId",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/place")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Place not found"
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
     *                  enum = {"country", "location", "featureClass", "featureCode", "timeZone"},
     *              )
     *          )
     *      ),
     * )
     * @param \App\Queries\PlaceQuery  $query
     * @param string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceQuery $query, $geonameId)
    {
        $place = $query
            ->applyScope('byGeonameId', Arr::wrap($geonameId))
            ->getBuilder()
            ->firstOrFail();

        return PlaceResource::make($place);
    }
}
