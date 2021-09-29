<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AlternateNameResource;
use App\Models\AlternateName;
use App\Models\Place;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\AlternateNameQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class PlaceAlternateNameController extends Controller
{
    /**
     * Display a location of a specific place.
     *
     * @OA\Get(
     *     tags={"Places"},
     *     path="/places/{geonameId}/names",
     *     operationId="getAlternateNamesForPlace",
     *     @OA\Property(ref="#/components/schemas/AlternateName"),
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
     *          description="Alternate name not found"
     *       ),
     * )
     * @param \App\Queries\PlaceQuery  $query
     * @param int $geonameId
     * @return \Illuminate\Http\Response
     */
    public function index(AlternateNameQuery $query, $geonameId)
    {
        if (! Place::where('geoname_id', $geonameId)->exists()) {
            throw (new ModelNotFoundException())->setModel(AlternateName::class);
        }

        $names = $query
            ->applyScope('byGeonameId', Arr::wrap($geonameId))
            ->getPaginator();

        return new PaginatedResourceResponse(
            AlternateNameResource::collection($names)
        );
    }
}
