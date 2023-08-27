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
     *      operationId="getFeatureClasses",
     *      path="/featureClasses",
     *
     *      @OA\Parameter(ref="#/components/parameters/featureClassFilter"),
     *      @OA\Parameter(ref="#/components/parameters/featureClassInclude"),
     *      @OA\Parameter(ref="#/components/parameters/featureClassSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/featureClass")
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=429,
     *          ref="#/components/responses/429"
     *      ),
     *
     *      security={ {"BearerAuth": {}} }
     * )
     *
     * @OA\Tag(
     *     name="Feature Classes",
     *     description="Everything about feature classes"
     * )
     *
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
     *
     *     @OA\Parameter(ref="#/components/parameters/featureClassCode"),
     *     @OA\Parameter(ref="#/components/parameters/featureClassInclude"),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\JsonContent(ref="#/components/schemas/featureClass")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         ref="#/components/responses/404"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/401"
     *     ),
     *          *      @OA\Response(
     *          response=429,
     *          ref="#/components/responses/429"
     *      ),
     *
     *      security={ {"BearerAuth": {}} }
     * )
     *
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
