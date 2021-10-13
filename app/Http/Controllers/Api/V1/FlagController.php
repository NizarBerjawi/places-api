<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\FlagQuery;
use Illuminate\Support\Arr;

class FlagController extends Controller
{
    /**
     * Display a listing of all flags.
     *
     * @OA\Get(
     *      tags={"Flags"},
     *      summary="Returns a list of paginated flags",
     *      path="/flags",
     *      @OA\Parameter(ref="#/components/parameters/flagFilter"),
     *      @OA\Parameter(ref="#/components/parameters/flagInclude"),
     *      @OA\Parameter(ref="#/components/parameters/flagSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/flag")
     *          ),
     *      ),
     * )
     * @OA\Tag(
     *     name="Flags",
     *     description="Everything about flags"
     * )
     *
     * @param \App\Queries\FlagQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(FlagQuery $query)
    {
        $flags = $query->getPaginator();

        return new PaginatedResourceResponse(
            FlagResource::collection($flags)
        );
    }

    /**
     * Display a specified flag.
     *
     * @OA\Get(
     *     tags={"Flags"},
     *     path="/flags/{countryCode}",
     *     operationId="getFlagByCode",
     *     @OA\Property(ref="#/components/schemas/flag"),
     *     @OA\Parameter(ref="#/components/parameters/countryCode"),
     *     @OA\Parameter(ref="#/components/parameters/flagInclude"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/flag")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Flag not found"
     *     )
     * )
     * @param \App\Queries\FlagQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FlagQuery $query, string $countryCode)
    {
        $flag = $query
            ->applyScope('byCountryCode', Arr::wrap($countryCode))
            ->getBuilder()
            ->firstOrFail();

        return FlagResource::make($flag);
    }
}
