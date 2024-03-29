<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GeometryCollection;
use App\Models\Continent;
use App\Queries\GeometryQuery;

class ContinentGeometryController extends Controller
{
    /**
     * Display the Geometry of a specific Continent.
     *
     * @OA\Get(
     *      tags={"Continents"},
     *      operationId="getContinentGeoJson",
     *      summary="Returns the GeoJSON object for a specific continent.",
     *      path="/continents/{continentCode}/geometry",
     *
     *      @OA\Parameter(ref="#/components/parameters/continentCode"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(ref="#/components/schemas/featureCollection")
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
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function index(GeometryQuery $query, string $continentCode)
    {
        $continent = Continent::query()
            ->where('code', $continentCode)
            ->with('geometries')
            ->firstOrFail();

        return GeometryCollection::make($continent->geometries);
    }
}
