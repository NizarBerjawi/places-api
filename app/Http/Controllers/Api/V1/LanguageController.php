<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\LanguageFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LanguageResource;
use App\Pagination\PaginatedResourceResponse;

class LanguageController extends Controller
{
    /**
     * Display a listing of all languages.
     *
     * @OA\Get(
     *      tags={"Languages"},
     *      summary="Returns a list of paginated languages",
     *      path="/languages",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/language")
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter languages by certain criteria",
     *          required=false,
     *          style="deepObject",
     *          @OA\Schema(
     *              type="object",
     *              enum={"countryCode"},
     *              @OA\Property(
     *                  property="countryCode",
     *                  type="string",
     *                  example="AU"
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
     *                  enum = {"countries"},
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
     *     name="Languages",
     *     description="Everything about languages"
     * )
     *
     * @param \App\Filters\LanguageFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageFilter $filter)
    {
        $languages = $filter->getPaginator();

        return new PaginatedResourceResponse(
            LanguageResource::collection($languages)
        );
    }
}
