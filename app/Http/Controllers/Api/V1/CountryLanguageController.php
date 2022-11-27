<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LanguageResource;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\LanguageQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryLanguageController extends Controller
{
    /**
     * Display the languages of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the languages of a specific country",
     *      path="/countries/{countryCode}/languages",
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *      @OA\Parameter(ref="#/components/parameters/languageFilter"),
     *      @OA\Parameter(ref="#/components/parameters/languageInclude"),
     *      @OA\Parameter(ref="#/components/parameters/languageSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/language")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *      )
     * )
     *
     * @param  \App\Queries\LanguageQuery  $query
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $language = $query
            ->applyScope('byCountry', Arr::wrap($countryCode))
            ->getPaginator();

        return new PaginatedResourceResponse(
            LanguageResource::collection($language)
        );
    }
}
