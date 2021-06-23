<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\LanguageFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LanguageResource;

class LanguageController extends Controller
{
    /**
     * Display a listing of all languages.
     *
     * @OA\Get(
     *      tags={"Languages"},
     *      summary="Returns a list of paginated languages",
     *      path="/api/v1/languages",
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
     *              enum={"country_code"},
     *              @OA\Property(
     *                  property="country_code",
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
     *                  enum = {"country"},
     *              )
     *          )
     *      ),
     * )
     * @OA\Tag(
     *     name="Flags",
     *     description="Everything about flags"
     * )
     *
     * @param \App\Filters\LanguageFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageFilter $filter)
    {
        $languages = $filter->getPaginator();

        return LanguageResource::collection($languages);
    }
}
