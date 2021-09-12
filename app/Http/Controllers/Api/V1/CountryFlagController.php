<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryFlagController extends Controller
{
    /**
     * Display the flag of a country.
     *
     * @OA\Get(
     *      tags={"Countries"},
     *      summary="Returns the flag of a specific country",
     *      path="/countries/{countryCode}/flag",
     *      @OA\Parameter(
     *         name="countryCode",
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
     *              @OA\Items(ref="#/components/schemas/flag")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Country not found"
     *       ),
     *      @OA\Parameter(
     *          name="include",
     *          in="query",
     *          description="Include resources related to the specified flag.",
     *          required=false,
     *          explode=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  enum = {"country"},
     *              )
     *          )
     *      ),
     * )
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(FlagFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $flag = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getBuilder()
            ->first();

        return FlagResource::make($flag);
    }
}
