<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Place;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Pluralizer;
use Ramsey\Uuid\Uuid;

class StatisticsController extends Controller
{
    const NAMESPACE = '4bdbe8ec-5cb5-11ea-bc55-0242ac130003';

    /**
     * Display a listing of all time zones.
     *
     * @OA\Get(
     *      tags={"Time Zones"},
     *      summary="Returns a list of paginated time zones",
     *      path="/timeZones",
     *      @OA\Parameter(ref="#/components/parameters/timeZoneFilter"),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneInclude"),
     *      @OA\Parameter(ref="#/components/parameters/timeZoneSort"),
     *      @OA\Parameter(ref="#/components/parameters/pagination"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/timeZone")
     *          ),
     *      ),
     * )
     * @OA\Tag(
     *     name="Time Zones",
     *     description="Everything about time zones"
     * )
     *
     * @param \App\Queries\TimeZoneQuery  $query
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classes = [
            Continent::class,
            Country::class,
            Place::class,
            Language::class,
            TimeZone::class,
            Currency::class,
        ];

        return new JsonResource(
            array_map(function ($class) {
                $uuid = Uuid::uuid5(self::NAMESPACE, $class);
                $className = class_basename($class);
                $plural = Pluralizer::plural($className);

                return [
                    'id' => $uuid,
                    'type' => 'count',
                    'label' => "{$plural}",
                    'value' => $class::count(),
                ];
            }, $classes)
        );
    }
}
