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
     *      operationId="getPlaces",
     *      summary="Returns a list of paginated places.",
     *      path="/places",
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
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/place")
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
     *     name="Places",
     *     description="Everything about places"
     * )
     *
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
     *     operationId="getPlaceDetails",
     *     summary="Returns the details of a specific place.",
     *     path="/places/{geonameId}",
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
     *         @OA\JsonContent(ref="#/components/schemas/place")
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
            ->applyScope('byGeonameId', Arr::wrap($geonameId))
            ->getBuilder()
            ->firstOrFail();

        return PlaceResource::make($place);
    }
}
