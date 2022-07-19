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

class StatisticsController extends Controller
{
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
        return new JsonResource([
                [
                    'key' => 'continents',
                    'description' => 'Continents',
                    'value' => Continent::count(),
                    'type' => 'count',
                ],
                [
                    'key' => 'countries',
                    'description' => 'Countries',
                    'value' => Country::count(),
                    'type' => 'count',
                ],
                [
                    'key' => 'places',
                    'description' => 'Places',
                    'value' => Place::count(),
                    'type' => 'count',
                ],
                [
                    'key' => 'languages',
                    'description' => 'Languages',
                    'value' => Language::count(),
                    'type' => 'count',
                ],
                [
                    'key' => 'timeZones',
                    'description' => 'Time Zones',
                    'value' => TimeZone::count(),
                    'type' => 'count',
                ],
                [
                    'key' => 'currencies',
                    'description' => 'Currencies',
                    'value' => Currency::count(),
                    'type' => 'count',
                ],
            ]
        );
    }
}
