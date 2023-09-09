<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LocationResource;
use App\Models\Place;
use App\Queries\LocationQuery;
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
     *     summary="Returns the location of a specific place.",
     *     operationId="getPlaceLocation",
     *
     *     @OA\Parameter(ref="#/components/parameters/geonameId"),
     *     @OA\Parameter(ref="#/components/parameters/pagination"),
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
     *                   ref="#/components/schemas/location"
     *              ),
     *          ),
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
     *     @OA\Response(
     *          response=429,
     *          ref="#/components/responses/429"
     *      ),
     *
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @param  \App\Queries\PlaceQuery  $query
     * @param  int  $geonameId
     * @return \Illuminate\Http\Response
     */
    public function index(LocationQuery $query, $geonameId)
    {
        if (! Place::where('geoname_id', $geonameId)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $location = $query
            ->applyScope('byPlace', Arr::wrap($geonameId))
            ->getBuilder()
            ->firstOrFail();

        return LocationResource::make($location);
    }
}
