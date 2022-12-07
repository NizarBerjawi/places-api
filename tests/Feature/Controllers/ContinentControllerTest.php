<?php

use App\Http\Resources\V1\ContinentResource;
use App\Models\Continent;
use App\Pagination\PaginatedResourceResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use function Pest\Laravel\getJson;

test('returns 200 response on GET continents', function () {
    getJson('/api/v1/continents')->assertOk();
});

test('returns correct structure on GET continents', function () {
    getJson('/api/v1/continents')->assertJsonStructure([
        'data' => [['code', 'name']],
        'links' => ['prev', 'next'],
        'meta' => ['path', 'perPage', 'nextCursor', 'prevCursor'],
    ]);
});

$continentFilters = [
    'code' => 'code',
    'name' => 'name',
];

foreach ($continentFilters as $key => $filter) {
    test("returns correct continent data by \"{$filter}\" when filtered", function () use ($key, $filter) {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $uri = "/api/v1/continents?filter[$filter][eq]=".urlencode($continent->{$key});

        $continentsCollection = Continent::query()
            ->where($key, $continent->{$key})
            ->jsonPaginate(config('json-api-paginate.default_size'));

        $resource = (new PaginatedResourceResponse(
            ContinentResource::collection($continentsCollection)
        ));

        $request = Request::create(url($uri));

        getJson($uri)
            ->assertOk()
            ->assertJson(
                Arr::only($resource->toResponse($request)->getData(true), 'data')
            );
    });
}

$continentIncludes = [
    'countries',
    'alternateNames',
];

test("returns correct data when \"{$include}\" are included for countries", function () use ($include) {
    $uri = '/api/v1/continents?include='.urlencode($include);

    $continentsCollection = Continent::query()
        ->with($include)
        ->jsonPaginate(config('json-api-paginate.default_size'));

    $resource = (new PaginatedResourceResponse(
        ContinentResource::collection($continentsCollection)
    ));

    $request = Request::create(url($uri), 'GET');

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            Arr::only($resource->toResponse($request)->getData(true), 'data')
        );
});

test('returns empty data when filters don\'t match for continents', function () {
    $continents = Continent::query()
        ->inRandomOrder()
        ->limit(2)
        ->get();

    $code = $continents->first()->code;
    $name = $continents->last()->name;

    getJson('/api/v1/continents?filter[code][eq]='.$code.'&filter[name][eq]='.$name)
        ->assertOk()
        ->assertJsonFragment([
            'data' => [],
        ]);
});

test('returns an error response with invalid include for continents', function () {
    $uri = '/api/v1/continents?include=invalid';

    getJson($uri)
        ->assertNotFound()
        ->assertExactJson(
            [
                'errors' => [
                    'message' => 'Requested include(s) `invalid` are not allowed.',
                    'status_code' => Response::HTTP_NOT_FOUND,
                ],
            ]
        );
});

test('returns sorted data when sorted by code for continents', function () {
    $uri = '/api/v1/continents?sort=-code';

    $continentsCollection = Continent::query()
        ->orderBy('code', 'DESC')
        ->jsonPaginate();

    $resource = (new PaginatedResourceResponse(
        ContinentResource::collection($continentsCollection)
    ));

    $request = Request::create(url($uri), 'GET');

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            $resource->toResponse($request)->getData(true)
        );
});

test('returns an error response with invalid sort for continents', function () {
    $uri = '/api/v1/continents?sort=invalid';

    getJson($uri)
        ->assertNotFound()
        ->assertExactJson(
            [
                'errors' => [
                    'message' => 'Requested sort(s) `invalid` is not allowed. Allowed sort(s) are `name, code`.',
                    'status_code' => Response::HTTP_NOT_FOUND,
                ],
            ]
        );
});

test('returns correct structure on GET continent', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    getJson('/api/v1/continents/'.$continent->code)
        ->assertJsonStructure([
            'data' => [
                'code',
                'name',
            ],
        ]);
});

test('returns correct data on GET continent', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $uri = 'api/v1/continents/'.$continent->code;

    $request = Request::create(url($uri));

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            ContinentResource::make($continent)
                ->toResponse($request)
                ->getData(true)
        );
});

test('returns correct data when "countries" are included for a continent', function () {
    $continent = Continent::query()
        ->with('countries')
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $uri = '/api/v1/continents/'.$continent->code.'?include=countries';

    $request = Request::create(url($uri), 'GET');

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            ContinentResource::make($continent)
                ->toResponse($request)
                ->getData(true)
        );
});

test('returns correct data when "alternate names" are included for a continent', function () {
    $continent = Continent::query()
        ->with('alternateNames')
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $uri = '/api/v1/continents/'.$continent->code.'?include=alternateNames';

    $request = Request::create(url($uri), 'GET');

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            ContinentResource::make($continent)
                ->toResponse($request)
                ->getData(true)
        );
});
