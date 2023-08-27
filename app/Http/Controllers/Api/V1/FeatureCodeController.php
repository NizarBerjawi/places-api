<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FeatureCodeResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\FeatureCodeQuery;
use Illuminate\Support\Arr;

class FeatureCodeController extends Controller
{
    /**
     * Display a listing of all feature codes.
     *
     * @OA\Get(
     *      tags={"Feature Codes"},
     *      summary="Returns a list of paginated feature codes",
     *      operationId="getFeatureCodes",
     *      path="/featureCodes",
     *
     *      @OA\Parameter(ref="#/components/parameters/featureCodeFilter"),
     *      @OA\Parameter(ref="#/components/parameters/featureCodeInclude"),
     *      @OA\Parameter(ref="#/components/parameters/featureCodeSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/featureCode")
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
     *     name="Feature Codes",
     *     description="Everything about feature codes"
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureCodeQuery $query)
    {
        $featureCodes = $query->getPaginator();

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
     *
     *     @OA\Property(ref="#/components/schemas/featureCode"),
     *
     *     @OA\Parameter(ref="#/components/parameters/featureCodeInclude"),
     *     @OA\Parameter(
     *        name="featureCodeCode",
     *        in="path",
     *        required=true,
     *
     *        @OA\Schema(
     *            type="string"
     *        )
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(ref="#/components/schemas/featureCode")
     *       ),
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
     *      security={ {"BearerAuth": {}} }
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureCodeQuery $query, string $featureCodeCode)
    {
        $featureCode = $query
            ->applyScope('byFeatureCodeCode', Arr::wrap($featureCodeCode))
            ->getBuilder()
            ->firstOrFail();

        return FeatureCodeResource::make($featureCode);
    }
}
