<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FeatureClassFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FeatureClassResource;

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
     *              @OA\Items(ref="#/components/schemas/feature_class")
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
     * @param  \App\Filters\FeatureClassFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureClassFilter $filter)
    {
        $featureClasses = $filter->getPaginator();

        return FeatureClassResource::collection($featureClasses);
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
     *          @OA\JsonContent(ref="#/components/schemas/feature_class")
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
     * @param  \App\Filters\FeatureClassFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureClassFilter $filter, string $code)
    {
        $featureClass = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new FeatureClassResource($featureClass);
    }
}
