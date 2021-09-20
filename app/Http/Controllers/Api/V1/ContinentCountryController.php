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
     *          name="filter",
     *          in="query",
     *          description="Filter countries by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={
     *                  "name",
     *                  "iso3166Alpha2",
     *                  "iso3166Alpha3",
     *                  "iso3166Numeric",
     *                  "population",
     *                  "area",
     *                  "phoneCode",
     *                  "areaGt",
     *                  "areaGte",
     *                  "areaLt",
     *                  "areaLte",
     *                  "areaBetween",
     *                  "populationGt",
     *                  "populationGte",
     *                  "populationLt",
     *                  "populationLte",
     *                  "populationBetween",
     *                  "neighbourOf"
     *              },
     *              @OA\Property(
     *                  property="areaLt",
     *                  type="integer",
     *                  example="100000"
     *              )
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include related resources with every country.",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {
     *                      "continent",
     *                      "timeZones",
     *                      "flag",
     *                      "neighbours",
     *                      "languages",
     *                      "currency"
     *                  },
     *              )
     *          )
     *      ),
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
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CountryQuery $query, string $code)
    {
        if (! Continent::where('code', $code)->exists()) {
            throw (new ModelNotFoundException)->setModel(Continent::class);
        }

        $countries = $query
            ->applyScope('byContinent', Arr::wrap($code))
            ->getPaginator();

        return new PaginatedResourceResponse(
            CountryResource::collection($countries)
        );
    }
}
