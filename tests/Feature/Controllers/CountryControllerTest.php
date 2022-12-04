<?php

use App\Http\Resources\V1\ContinentResource;
use App\Http\Resources\V1\CountryResource;
use App\Models\Continent;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function Pest\Laravel\getJson;

test('returns 200 response on GET countries', function () {
    getJson('/api/v1/countries')->assertOk();
});

test('returns correct structure on GET countries', function () {
    getJson('/api/v1/countries')->assertJsonStructure([
        'data' => [[
            'name',
            'iso3166Alpha2',
            'iso3166Alpha3',
            'iso3166Numeric',
            'population',
            'area',
            'phoneCode',
        ]],
        'links' => ['prev', 'next'],
        'meta' => ['path', 'perPage', 'nextCursor', 'prevCursor'],
    ]);
});

$filters = [
    'name' => 'name',
    'iso3166_alpha2' => 'iso3166Alpha2',
    'iso3166_alpha3' => 'iso3166Alpha3',
    'iso3166_numeric' => 'iso3166Numeric',
    'population' => 'population',
    'area' => 'area',
    'phone_code' => 'phoneCode',
];

foreach ($filters as $key => $filter) {
    test("returns correct countries by \"{$filter}\" when filtered", function () use ($key, $filter) {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $uri = "/api/v1/countries?filter[$filter][eq]=".$country->{$key};

        $countriesCollection = Country::query()
            ->where($key, $country->{$key})
            ->jsonPaginate();

        $resource = (new PaginatedResourceResponse(
            CountryResource::collection($countriesCollection)
        ));

        $request = Request::create(url($uri));

        getJson($uri)
            ->assertOk()
            ->assertExactJson(
                $resource->toResponse($request)->getData(true)
            );
    });
}

test('returns empty data when filters don\'t match for countries', function () {
    $country = Country::query()
        ->inRandomOrder()
        ->limit(2)
        ->get();

    $code = $country->first()->iso3166_alpha2;
    $name = $country->last()->name;

    getJson('/api/v1/countries?filter[iso3166Alpha2][eq]='.$code.'&filter[name][eq]='.$name)
        ->assertOk()
        ->assertJsonFragment([
            'data' => [],
        ]);
});

$includes = [
    'continent',
    'timeZones',
    'flag',
    'neighbours',
    'languages',
    'currency',
    'alternateNames',
    'location',
];

foreach ($includes as $key => $include) {
    test("returns correct data when \"{$include}\" are included for countries", function () use ($include) {
        $uri = '/api/v1/countries?include='.$include;

        $request = Request::create(url($uri), 'GET');

        $countriesCollection = Country::query()
            ->with($include)
            ->jsonPaginate();

        $resource = (new PaginatedResourceResponse(
            CountryResource::collection($countriesCollection)
        ));

        getJson($uri)
            ->assertOk()
            ->assertExactJson(
                $resource->toResponse($request)->getData(true)
            );
    });
}

test('returns an error response with invalid include for countries', function () {
    $uri = '/api/v1/countries?include=invalid';

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
