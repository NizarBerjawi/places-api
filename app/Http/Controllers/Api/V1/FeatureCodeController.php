<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FeatureCodeFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FeatureCodeResource;

class FeatureCodeController extends Controller
{
    /**
     * Display a listing of all feature codes.
     *
     * @OA\Get(
     *      tags={"Feature Codes"},
     *      summary="Returns a list of paginated feature codes",
     *      path="/api/v1/featureCodes",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/feature_code")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter feature codes by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={"code"},
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  example="ADM1"
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
     *                  enum = {"featureClass"},
     *              )
     *          )
     *      ),
     * )
     * @OA\Tag(
     *     name="Feature Codes",
     *     description="Everything about feature codes"
     * )
     *
     * @param  \App\Filters\FeatureCodeFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureCodeFilter $filter)
    {
        $featureCodes = $filter->getPaginator();

        return FeatureCodeResource::collection($featureCodes);
    }

    /**
     * Display a specified feature code.
     *
     * @OA\Get(
     *     tags={"Feature Codes"},
     *     path="/api/v1/featureCodes/{featureCodeCode}",
     *     operationId="getFeatureCodeByCode",
     *     @OA\Property(ref="#/components/schemas/featureCode"),
     *     @OA\Parameter(
     *        name="featureCodeCode",
     *        in="path",
     *        required=true,
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/feature_code")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Feature code not found"
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
     *                  enum = {"featureClass"},
     *              )
     *          )
     *      ),
     * )
     * @param  \App\Filters\FeatureCodeFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureCodeFilter $filter, string $code)
    {
        $featureCode = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new FeatureCodeResource($featureCode);
    }
}
