<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FeatureCodeFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FeatureCodeResource;
use App\Pagination\PaginatedResourceResponse;

class FeatureCodeController extends Controller
{
    /**
     * Display a listing of all feature codes.
     *
     * @OA\Get(
     *      tags={"Feature Codes"},
     *      summary="Returns a list of paginated feature codes",
     *      path="/featureCodes",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/featureCode")
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

        return new PaginatedResourceResponse(
            FeatureCodeResource::collection($featureCodes)
        );
    }

    /**
     * Display a specified feature code.
     *
     * @OA\Get(
     *     tags={"Feature Codes"},
     *     path="/featureCodes/{featureCodeCode}",
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
     *          @OA\JsonContent(ref="#/components/schemas/featureCode")
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
