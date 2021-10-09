<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FeatureClassResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\FeatureClassQuery;
use Illuminate\Support\Arr;

class FeatureClassController extends Controller
{
    /**
     * Display a listing of all feature classes.
     *
     * @OA\Get(
     *      tags={"Feature Classes"},
     *      summary="Returns a list of paginated feature classes",
     *      path="/featureClasses",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/featureClass")
     *          ),
     *      ),
     *      @OA\Parameter(ref="#/components/parameters/featureClassFilter"),
     *      @OA\Parameter(ref="#/components/parameters/featureClassInclude"),
     *      @OA\Parameter(ref="#/components/parameters/featureClassSort"),
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
     *      )
     * )
     * @OA\Tag(
     *     name="Feature Classes",
     *     description="Everything about feature classes"
     * )
     *
     * @param  \App\Queries\FeatureClassQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureClassQuery $query)
    {
        $featureClasses = $query->getPaginator();

        return new PaginatedResourceResponse(
            FeatureClassResource::collection($featureClasses)
        );
    }

    /**
     * Display a specified feature class.
     *
     * @OA\Get(
     *     tags={"Feature Classes"},
     *     path="/featureClasses/{featureClassCode}",
     *     operationId="getFeatureClassByCode",
     *     @OA\Parameter(ref="#/components/parameters/featureClassCode"),
     *     @OA\Parameter(ref="#/components/parameters/featureClassInclude"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/featureClass")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Feature class not found"
     *     )
     * )
     * @param  \App\Queries\FeatureClassQuery  $query
     * @param  string $featureClassCode
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureClassQuery $query, string $featureClassCode)
    {
        $featureClass = $query
            ->applyScope('byFeatureClassCode', Arr::wrap($featureClassCode))
            ->getBuilder()
            ->firstOrFail();

        return FeatureClassResource::make($featureClass);
    }
}
