<?php

use App\Http\Resources\V1\ContinentResource;
use App\Models\Continent;
use App\Pagination\PaginatedResourceResponse;
use Illuminate\Http\Request;

use function Pest\Laravel\getJson;

test('returns correct structure on GET continents', function () {
    getJson('/api/v1/continents')->assertJsonStructure([
        'data' => [['code', 'name']],
        'links' => ['prev', 'next'],
        'meta' => ['path', 'perPage', 'nextCursor', 'prevCursor'],
    ]);
});

test('returns 200 response on GET continents', function () {
    getJson('/api/v1/continents')->assertOk();
});

test('returns correct pagination limit on GET continents', function () {
    $response = getJson('/api/v1/continents');

    $this->assertEquals(
        Arr::get($response, 'meta.perPage'),
        config('geonames.pagination_limit')
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

test('returns correct structure and data on show continent', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    getJson('/api/v1/continents/' . $continent->code)
        ->assertJson([
            'data' => [
                'code' =>  $continent->code,
                'name' => $continent->name,
            ],
        ]);
});

test('returns correct continent by code filter', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    getJson('/api/v1/continents?filter[code][eq]=' . $continent->code)
        ->assertJson([
            'data' => [[
                'code' => $continent->code,
                'name' => $continent->name,
            ]],
        ]);
});

test('returns correct continent by name filter', function () {
    https://stackoverflow.com/questions/61871036/how-to-test-laravel-resource

    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $continentsCollection = Continent::query()
        ->where('code', $continent->code)
        ->get();

    $resource = (new PaginatedResourceResponse(
        ContinentResource::collection($continentsCollection)
    ));

    $request = Request::create('/api/v1/continents?filter[name][eq]=' . $continent->name, 'GET');

    dd( $resource);
    // getJson('/api/v1/continents?filter[name][eq]=' . $continent->name)
    //     ->assertSimilarJson(
           
    //     );
});
