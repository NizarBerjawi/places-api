<?php

use App\Http\Resources\V1\CountryResource;
use App\Models\Continent;
use App\Models\Country;
use App\Pagination\PaginatedResourceResponse;
use function Pest\Laravel\getJson;
use Symfony\Component\HttpFoundation\Response;

test('returns 200 response on GET countries', function () {
    $continent = Continent::query()
    ->inRandomOrder()
    ->limit(1)
    ->first();

    getJson('/api/v1/continents/'.$continent->getKey().'/countries')->assertOk();
});

test('returns correct structure on GET countries', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    getJson('/api/v1/continents/'.$continent->getKey().'/countries')->assertJsonStructure([
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

$countryFilters = [
    'name' => 'name',
    'iso3166_alpha2' => 'iso3166Alpha2',
    'iso3166_alpha3' => 'iso3166Alpha3',
    'iso3166_numeric' => 'iso3166Numeric',
    'population' => 'population',
    'area' => 'area',
    'phone_code' => 'phoneCode',
];

foreach ($countryFilters as $key => $filter) {
    test("returns correct country data by \"{$filter}\" when filtered", function () use ($key, $filter) {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $country = Country::query()
            ->where('continent_code', $continent->getKey())
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $query = http_build_query([
            'filter' => [
                $filter => [
                    'eq' => $country->{$key},
                ],
            ],
        ]);

        $uri = '/api/v1/continents/'.$continent->getKey().'/countries?'.$query;

        $countriesCollection = Country::query()
            ->where('continent_code', $continent->getKey())
            ->where($key, $country->{$key})
            ->jsonPaginate(config('json-api-paginate.default_size'));

        $resource = (new PaginatedResourceResponse(
            CountryResource::collection($countriesCollection)
        ));

        $request = Request::create(url($uri));

        getJson($uri)
            ->assertOk()
            ->assertJson(
                Arr::only($resource->toResponse($request)->getData(true), 'data')
            );
    });
}

$countryIncludes = [
    'continent',
    'timeZones',
    'flag',
    'neighbours',
    'languages',
    'currency',
    'alternateNames',
    'location',
];

foreach ($countryIncludes as $include) {
    test("returns correct data when \"{$include}\" relation is included for countries", function () use ($include) {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $query = http_build_query([
            'include' => $include,
        ]);

        $uri = '/api/v1/continents/'.$continent->getKey().'/countries?'.$query;

        $countriesCollection = Country::query()
            ->where('continent_code', $continent->getKey())
            ->with($include)
            ->jsonPaginate(config('json-api-paginate.default_size'));

        $resource = (new PaginatedResourceResponse(
            CountryResource::collection($countriesCollection)
        ));

        $request = Request::create(url($uri), 'GET');

        getJson($uri)
            ->assertOk()
            ->assertJson(
                Arr::only($resource->toResponse($request)->getData(true), 'data')
            );
    });
}

$countrySorts = [
    'name' => 'name',
    'iso3166_alpha2' => 'iso3166Alpha2',
    'iso3166_alpha3' => 'iso3166Alpha3',
    'iso3166_numeric' => 'iso3166Numeric',
    'population' => 'population',
    'area' => 'area',
    'phone_code' => 'phoneCode',
];

foreach ($countrySorts as $key => $sort) {
    test("returns correct data when sorted by \"{$sort}\" for countries", function () use ($key, $sort) {
        $directions = ['ASC' => '+', 'DESC' => '-'];

        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        foreach ($directions as $direction => $operator) {
            $uri = '/api/v1/continents/'.$continent->getKey().'/countries?sort='.$operator.urlencode($sort);

            $request = Request::create(url($uri), 'GET');

            $countriesCollection = Country::query()
                ->where('continent_code', $continent->getKey())
                ->orderBy($key, $direction)
                ->jsonPaginate(config('json-api-paginate.default_size'));

            $resource = (new PaginatedResourceResponse(
                CountryResource::collection($countriesCollection)
            ));

            getJson($uri)
                ->assertOk()
                ->assertJson(
                    Arr::only($resource->toResponse($request)->getData(true), 'data')
                );
        }
    });
}

test('returns empty data when filters don\'t match for countries', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $countries = Country::query()
        ->where('continent_code', $continent->getKey())
        ->inRandomOrder()
        ->limit(2)
        ->get();

    $code = $countries->first()->iso3166_alpha2;
    $name = $countries->last()->name;

    $query = http_build_query([
        'filter' => [
            'iso3166Alpha2' => [
                'eq' => $code,
            ],
            'name' => [
                'eq' => $name,
            ],
        ],
    ]);

    $uri = '/api/v1/continents/'.$continent->getKey().'/countries?'.$query;

    getJson('/api/v1/continents/'.$continent->getKey().'/countries?'.$query)
        ->assertOk()
        ->assertJsonFragment([
            'data' => [],
        ]);
});

// test('returns an error response when invalid filter for countries', function () use ($countryFilters) {
//     $continent = Continent::query()
//         ->inRandomOrder()
//         ->limit(1)
//         ->first();

//     $uri = '/api/v1/continents/'.$continent->getKey().'/countries?filter[invalid][eq]=invalid';

//     getJson($uri)
//         ->assertNotFound()
//         ->assertExactJson(
//             [
//                 'errors' => [
//                     'message' => 'Requested filter(s) `invalid` are not allowed. Allowed filter(s) are `'.implode(', ', $countryFilters).'`.',
//                     'status_code' => Response::HTTP_NOT_FOUND,
//                 ],
//             ]
//         );
// });

// test('returns an error response when invalid include for countries', function () {
//     $continent = Continent::query()
//     ->inRandomOrder()
//     ->limit(1)
//     ->first();

//     $uri = '/api/v1/continents/'.$continent->getKey().'/countries?include=invalid';

//     getJson($uri)
//         ->assertNotFound()
//         ->assertExactJson(
//             [
//                 'errors' => [
//                     'message' => 'Requested include(s) `invalid` are not allowed.',
//                     'status_code' => Response::HTTP_NOT_FOUND,
//                 ],
//             ]
//         );
// });

// test('returns an error response when invalid sort for countries', function () use ($countrySorts) {
//     $continent = Continent::query()
//     ->inRandomOrder()
//     ->limit(1)
//     ->first();

//     $uri = '/api/v1/continents/'.$continent->getKey().'/countries?sort=invalid';

//     getJson($uri)
//         ->assertNotFound()
//         ->assertExactJson(
//             [
//                 'errors' => [
//                     'message' => 'Requested sort(s) `invalid` is not allowed. Allowed sort(s) are `'.implode(', ', $countrySorts).'`.',
//                     'status_code' => Response::HTTP_NOT_FOUND,
//                 ],
//             ]
//         );
// });
