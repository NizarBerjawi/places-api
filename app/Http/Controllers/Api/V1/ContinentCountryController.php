<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;
use App\Models\Continent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class ContinentCountryController extends Controller
{
    /**
     * Display a listing of all countries in a continent.
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
     *          name="include",
     *          in="query",
     *          description="Include related resources",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"continent", "timeZones", "flag", "neighbours"},
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
     * @param \App\Filters\CountryFilter  $filter
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter, string $code)
    {
        if (! Continent::where('code', $code)->exists()) {
            throw (new ModelNotFoundException)->setModel(Continent::class);
        }

        $countries = $filter
            ->applyScope('byContinent', Arr::wrap($code))
            ->getPaginator();

        return CountryResource::collection($countries);
    }
}
