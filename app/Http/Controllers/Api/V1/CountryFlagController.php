<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;
use App\Models\Country;
use App\Queries\FlagQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryFlagController extends Controller
{
    /**
     * Display the flag of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      operationId="getCountryFlag",
     *      summary="Returns the national flag of a specific country.",
     *      path="/countries/{countryCode}/flag",
     *
     *      @OA\Parameter(ref="#/components/parameters/countryCode"),
     *      @OA\Parameter(ref="#/components/parameters/flagFilter"),
     *      @OA\Parameter(ref="#/components/parameters/flagInclude"),
     *      @OA\Parameter(ref="#/components/parameters/flagSort"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/flag")
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
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function index(FlagQuery $query, string $countryCode)
    {
        if (! Country::where('iso3166_alpha2', $countryCode)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $flag = $query
            ->applyScope('byCountryCode', Arr::wrap($countryCode))
            ->getBuilder()
            ->firstOrFail();

        return FlagResource::make($flag);
    }
}
