<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AlternateNameResource;
use App\Models\Continent;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\AlternateNameQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class ContinentAlternateNameController extends Controller
{
    /**
     * Display the alternate names of a continent in different languages.
     *
     * @OA\Get(
     *      tags={"Continents"},
     *      summary="Returns the alternate names of a specific continent",
     *      path="/continents/{continentCode}/alternateNames",
     *      @OA\Parameter(ref="#/components/parameters/continentCode"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameFilter"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameInclude"),
     *      @OA\Parameter(ref="#/components/parameters/alternateNameSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/alternateName")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Alternate name not found"
     *       ),
     * )
     *
     * @param  \App\Queries\CurrencyQuery  $query
     * @param  string $continentCode
     * @return \Illuminate\Http\Response
     */
    public function index(AlternateNameQuery $query, string $continentCode)
    {
        if (! Continent::where('code', $continentCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Continent::class);
        }

        $alternateNames = $query
            ->applyScope('byGeonameId', Arr::wrap(
                Continent::find($continentCode)->geoname_id
            ))
            ->getPaginator();

        return new PaginatedResourceResponse(
            AlternateNameResource::collection($alternateNames)
        );
    }
}
