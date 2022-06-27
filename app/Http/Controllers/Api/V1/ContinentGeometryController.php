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
     *      summary="Returns the geometry of a specific continent",
     *      path="/continents/{continentCode}/geometry",
     *      @OA\Parameter(ref="#/components/parameters/continentCode"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/featureCollection")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Continent not found"
     *       )
     * )
     *
     * @param  \App\Queries\GeometryQuery  $query
     * @param  string $code
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
