<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FeatureClassResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\FeatureClassQuery;

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
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter feature classes by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={"code"},
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  example="A"
     *              )
     *          )
     *      ),
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
     *                  enum = {"featureCodes"},
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
     *     @OA\Property(ref="#/components/schemas/featureClass"),
     *     @OA\Parameter(
     *        name="featureClassCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/featureClass")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Feature class not found"
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
     *                  enum = {"featureCodes"},
     *              )
     *          )
     *      ),
     * )
     * @param  \App\Queries\FeatureClassQuery  $query
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureClassQuery $query, string $code)
    {
        $featureClass = $query
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new FeatureClassResource($featureClass);
    }
}
