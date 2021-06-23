<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PlaceResource;

class PlaceController extends Controller
{
    /**
     * Display a listing of all places.
     *
     * @OA\Get(
     *      tags={"Places"},
     *      summary="Returns a list of paginated places",
     *      path="/api/v1/places",
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
     *                  "feature_code",
     *                  "country_code",
     *                  "population_gt",
     *                  "population_gte",
     *                  "population_lt",
     *                  "population_lte",
     *                  "population_between"
     *              },
     *              @OA\Property(
     *                  property="population_gt",
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
     *                  enum = {"country", "location", "feature_code"},
     *              )
     *          )
     *      ),
     * )
     * @OA\Tag(
     *     name="Places",
     *     description="Everything about places"
     * )
     *
     * @param \App\Filters\PlaceFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceFilter $filter)
    {
        $places = $filter->getPaginator();

        return PlaceResource::collection($places);
    }

    /**
     * Display a specified place.
     *
     * @OA\Get(
     *     tags={"Places"},
     *     path="/api/v1/places/{uuid}",
     *     operationId="getPlaceByUuid",
     *     @OA\Property(ref="#/components/schemas/Place"),
     *     @OA\Parameter(
     *        name="uuid",
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
     *                  enum = {"country", "location", "feature_code"},
     *              )
     *          )
     *      ),
     * )
     * @param \App\Filters\PlaceFilter  $filter
     * @param string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceFilter $filter, string $uuid)
    {
        $place = $filter
            ->getBuilder()
            ->where('uuid', $uuid)
            ->firstOrFail();

        return PlaceResource::make($place);
    }
}
