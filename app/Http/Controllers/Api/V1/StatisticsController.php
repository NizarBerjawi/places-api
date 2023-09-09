<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AlternateName;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Currency;
use App\Models\FeatureClass;
use App\Models\FeatureCode;
use App\Models\Flag;
use App\Models\Language;
use App\Models\Place;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Pluralizer;
use Ramsey\Uuid\Uuid;

class StatisticsController extends Controller
{
    const NAMESPACE = '4bdbe8ec-5cb5-11ea-bc55-0242ac130003';

    /**
     * Display a listing of all time zones.
     *
     * @OA\Get(
     *      tags={"Statistics"},
     *      summary="Returns a collection of statistics.",
     *      operationId="getStatistics",
     *      path="/statistics",
     *
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
     *                   @OA\Items(ref="#/components/schemas/statistics")
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
     *     name="Statistics",
     *     description="Statistics about the data"
     * )
     *
     * @param  \App\Queries\TimeZoneQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classes = Collection::make([
            Continent::class,
            Country::class,
            Currency::class,
            FeatureClass::class,
            FeatureCode::class,
            Flag::class,
            Language::class,
            Place::class,
            TimeZone::class,
            AlternateName::class,
        ]);

        $statistics = $classes->map(function ($class) {
            $uuid = Uuid::uuid5(self::NAMESPACE, $class);
            $className = class_basename($class);
            $plural = Pluralizer::plural($className);

            return [
                'id' => $uuid,
                'type' => 'count',
                'label' => "{$plural}",
                'value' => $class::count(),
            ];
        });

        return [
            'data' => $statistics,
            'links' => [
                'prev' => null,
                'next' => null,
            ],
            'meta' => [
                'nextCursor' => null,
                'path' => $request->fullUrl(),
                'perPage' => $classes->count(),
                'prevCursor' => null,
            ],
        ];
    }
}
