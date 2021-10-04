<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;
use App\Models\Continent;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\CountryQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class ContinentCountryController extends Controller
{
    /**
     * Display a listing of all countries available in a specified continent.
     *
     * @OA\Get(
     *      tags={"Continents"},
     *      summary="Returns a list of paginated countries in a specific continent",
     *      path="/continents/{continentCode}/countries",
     *      @OA\Parameter(
     *         name="continentCode",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Parameter(ref="#/components/parameters/countryFilter"),
     *      @OA\Parameter(ref="#/components/parameters/countryInclude"),
     *      @OA\Parameter(ref="#/components/parameters/countrySort"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/country")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Continent not found"
     *       ),
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
     *
     * @param \App\Queries\CountryQuery  $query
     * @param string $continentCode
     * @return \Illuminate\Http\Response
     */
    public function index(CountryQuery $query, string $continentCode)
    {
        if (! Continent::where('code', $continentCode)->exists()) {
            throw (new ModelNotFoundException)->setModel(Continent::class);
        }

        $countries = $query
            ->applyScope('byContinentCode', Arr::wrap($continentCode))
            ->getPaginator();

        return new PaginatedResourceResponse(
            CountryResource::collection($countries)
        );
    }
}
