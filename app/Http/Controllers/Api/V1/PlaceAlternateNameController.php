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
     * Display the alternate names of a place.
     *
     * @OA\Get(
     *      tags={"Places"},
     *      path="/places/{geonameId}/alternateNames",
     *      operationId="getAlternateNamesByPlace",
     *
     *      @OA\Property(ref="#/components/schemas/AlternateName"),
     *
     *      @OA\Parameter(ref="#/components/parameters/geonameId"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameFilter"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameInclude"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(ref="#/components/schemas/location")
     *      ),
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
     *      security={ {"Bearer Authentication": {}} }
     * )
     *
     * @param  \App\Queries\PlaceQuery  $query
     * @param  int  $geonameId
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
