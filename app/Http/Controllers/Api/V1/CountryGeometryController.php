<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GeometryCollection;
use App\Models\Country;
use App\Queries\GeometryQuery;
use Illuminate\Support\Arr;

class CountryGeometryController extends Controller
{
    /**
     * Display the Geometry of a Country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the geometry of a specific country",
     *      path="/countries/{countryCode}/geometry",
     *
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/featureCollection")
     *          ),
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
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function index(GeometryQuery $query, string $countryCode)
    {
        $country = Country::query()
            ->where('iso3166_alpha2', $countryCode)
            ->with('geometry')
            ->firstOrFail();

        return GeometryCollection::make(Arr::wrap($country->geometry));
    }
}
