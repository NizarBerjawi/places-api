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
     *      summary="Returns a list of paginated languages",
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
     *              type="array",
     *
     *              @OA\Items(ref="#/components/schemas/language")
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
     *      security={ {"Bearer Authentication": {}} }
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
     *     path="/languages/{languageCode}",
     *     operationId="getLanguageByCode",
     *
     *     @OA\Parameter(ref="#/components/parameters/languageCode"),
     *     @OA\Parameter(ref="#/components/parameters/languageInclude"),
     *
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *
     *          @OA\JsonContent(ref="#/components/schemas/language")
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
     *      security={ {"Bearer Authentication": {}} }
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
