<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\LocationFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LocationResource;
use App\Models\Place;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class PlaceLocationController extends Controller
{
    /**
     * Display a location of a specific place.
     *
     * @OA\Get(
     *     tags={"Places"},
     *     path="/places/{geonameId}/location",
     *     operationId="getLocationByPlace",
     *     @OA\Property(ref="#/components/schemas/Place"),
     *     @OA\Parameter(
     *        name="geonameId",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/location")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Place not found"
     *       ),
     * )
     * @param \App\Filters\PlaceFilter  $filter
     * @param int $geonameId
     * @return \Illuminate\Http\Response
     */
    public function index(LocationFilter $filter, $geonameId)
    {
        if (! Place::where('geoname_id', $geonameId)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $location = $filter
            ->applyScope('byPlace', Arr::wrap($geonameId))
            ->getBuilder()
            ->first();

        return LocationResource::make($location);
    }
}
