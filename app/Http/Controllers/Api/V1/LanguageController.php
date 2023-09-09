<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LanguageResource;
use App\Pagination\PaginatedResourceResponse;
use App\Queries\LanguageQuery;
use Illuminate\Support\Arr;

class LanguageController extends Controller
{
    /**
     * Display a listing of all languages.
     *
     * @OA\Get(
     *      tags={"Languages"},
     *      operationId="getLanguages",
     *      summary="Returns a list of paginated languages.",
     *      path="/languages",
     *
     *      @OA\Parameter(ref="#/components/parameters/languageFilter"),
     *      @OA\Parameter(ref="#/components/parameters/languageInclude"),
     *      @OA\Parameter(ref="#/components/parameters/languageSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                   property="data",
     *                   type="array",
     *
     *                   @OA\Items(ref="#/components/schemas/language")
     *              ),
     *
     *              @OA\Property(
     *                   property="links",
     *                   ref="#/components/schemas/collectionLinks",
     *              ),
     *              @OA\Property(
     *                   property="meta",
     *                   ref="#/components/schemas/collectionMeta",
     *              )
     *          )
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
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @OA\Tag(
     *     name="Languages",
     *     description="Everything about languages"
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageQuery $query)
    {
        $languages = $query->getPaginator();

        return new PaginatedResourceResponse(
            LanguageResource::collection($languages)
        );
    }

    /**
     * Display a specified language.
     *
     * @OA\Get(
     *     tags={"Languages"},
     *     operationId="getLanguageDetails",
     *     summary="Returns the details of a specific language.",
     *     path="/languages/{languageCode}",
     *
     *     @OA\Parameter(ref="#/components/parameters/languageCode"),
     *     @OA\Parameter(ref="#/components/parameters/languageInclude"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                   property="data",
     *                   type="object",
     *                   ref="#/components/schemas/language"
     *              ),
     *          ),
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
     *      security={ {"bearerAuth": {}} }
     * )
     *
     * @param  \App\Queries\FlagQuery  $query
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show(LanguageQuery $query, string $languageCode)
    {
        $language = $query
            ->applyScope('byLanguageCode', Arr::wrap($languageCode))
            ->getBuilder()
            ->firstOrFail();

        return LanguageResource::make($language);
    }
}
