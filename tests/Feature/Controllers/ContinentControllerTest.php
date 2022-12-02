<?php

use App\Http\Resources\V1\ContinentResource;
use App\Models\Continent;
use App\Pagination\PaginatedResourceResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

test('returns correct pagination limit on GET continents', function () {
    $response = getJson('/api/v1/continents');

    $this->assertEquals(
        Arr::get($response, 'meta.perPage'),
        config('geonames.pagination_limit')
    );
});

test('returns correct continents by "code" filter', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $uri = '/api/v1/continents?filter[code][eq]=' . $continent->code;

    $continentsCollection = Continent::query()
        ->where('code', $continent->code)
        ->jsonPaginate();

    $resource = (new PaginatedResourceResponse(
        ContinentResource::collection($continentsCollection)
    ));

    $request = Request::create(url($uri));

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            $resource->toResponse($request)->getData(true)
        );
});

test('returns correct continents by "name" filter', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $uri = 'api/v1/continents?filter[name][eq]=' . $continent->name;
    $continentsCollection = Continent::query()
        ->where('name', $continent->name)
        ->jsonPaginate();

    $resource = (new PaginatedResourceResponse(
        ContinentResource::collection($continentsCollection)
    ));

    $request = Request::create(url($uri));

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            $resource->toResponse($request)->getData(true)
        );
});

test('returns empty data when filters don\'t match for continents', function () {
    $continents = Continent::query()
        ->inRandomOrder()
        ->limit(2)
        ->get();

    $code = $continents->first()->code;
    $name = $continents->last()->name;

    getJson('/api/v1/continents?filter[code][eq]=' . $code . '&filter[name][eq]=' . $name)
        ->assertOk()
        ->assertJsonFragment([
            'data' => [],
        ]);
});

test('returns correct data when "countries" are included for continents', function () {
    $uri = '/api/v1/continents?include=countries';

    $continentsCollection = Continent::query()
        ->with('countries')
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

test('returns correct data when "alternate names" are included for continents', function () {
    $uri = '/api/v1/continents?include=alternateNames';

    $continentsCollection = Continent::query()
        ->with('alternateNames')
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

    getJson('/api/v1/continents/' . $continent->code)
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

    $uri = 'api/v1/continents/' . $continent->code;

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

    $uri = '/api/v1/continents/' . $continent->code . '?include=countries';

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

    $uri = '/api/v1/continents/' . $continent->code . '?include=alternateNames';

    $request = Request::create(url($uri), 'GET');

    getJson($uri)
        ->assertOk()
        ->assertExactJson(
            ContinentResource::make($continent)
                ->toResponse($request)
                ->getData(true)
        );
});
