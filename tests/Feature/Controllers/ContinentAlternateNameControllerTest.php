<?php

use App\Http\Resources\V1\AlternateNameResource;
use App\Models\AlternateName;
use App\Models\Continent;
use App\Pagination\PaginatedResourceResponse;
use function Pest\Laravel\getJson;
use Symfony\Component\HttpFoundation\Response;

test('returns 200 response on GET alternate names', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    getJson('/api/v1/continents/'.$continent->getKey())->assertOk();
});

test('returns correct structure on GET alternate names', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    getJson('/api/v1/continents/'.$continent->getKey().'/alternateNames')->assertJsonStructure([
        'data' => [['name', 'isPreferredName', 'isShortName', 'isHistoric', 'isColloquial']],
        'links' => ['prev', 'next'],
        'meta' => ['path', 'perPage', 'nextCursor', 'prevCursor'],
    ]);
});

$alternateNameFilters = [
    'name' => 'name',
    'is_preferred_name' => 'isPreferredName',
    'is_short_name' => 'isShortName',
    'is_historic' => 'isHistoric',
    'is_colloquial' => 'isColloquial',
    'language_code' => 'languageCode',
];

foreach ($alternateNameFilters as $key => $filter) {
    test("returns correct alternate name data by \"{$filter}\" when filtered", function () use ($key, $filter) {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $alternateName = $continent
            ->alternateNames()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $query = http_build_query([
            'filter' => [
                $filter => [
                    'eq' => $alternateName->{$key},
                ],
            ],
        ]);

        $uri = '/api/v1/continents/'.$continent->getKey().'/alternateNames?'.$query;

        $alternateNamesCollection = AlternateName::query()
            ->byGeonameId($continent->geoname_id)
            ->where($key, $alternateName->{$key})
            ->jsonPaginate(config('json-api-paginate.default_size'));

        $resource = (new PaginatedResourceResponse(
            AlternateNameResource::collection($alternateNamesCollection)
        ));

        $request = Request::create(url($uri));

        getJson($uri)
            ->assertOk()
            ->assertJson(
                Arr::only($resource->toResponse($request)->getData(true), 'data')
            );
    });
}

$alternateNameIncludes = ['language', 'place'];

foreach ($alternateNameIncludes as $include) {
    test("returns correct data when \"{$include}\" relation is included for alternate name", function () use ($include) {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $uri = '/api/v1/continents/'.$continent->getKey().'/alternateNames?include='.urlencode($include);

        $alternateNamesCollection = AlternateName::query()
            ->byGeonameId($continent->geoname_id)
            ->with($include)
            ->jsonPaginate(config('json-api-paginate.default_size'));

        $resource = (new PaginatedResourceResponse(
            AlternateNameResource::collection($alternateNamesCollection)
        ));

        $request = Request::create(url($uri), 'GET');

        getJson($uri)
            ->assertOk()
            ->assertJson(
                Arr::only($resource->toResponse($request)->getData(true), 'data')
            );
    });
}

$alternateNameSorts = [
    'name' => 'name',
    'is_preferred_name' => 'isPreferredName',
    'is_short_name' => 'isShortName',
    'is_historic' => 'isHistoric',
    'is_colloquial' => 'isColloquial',
    'language_code' => 'languageCode',
];

foreach ($alternateNameSorts as $key => $sort) {
    test("returns correct data when sorted by \"{$sort}\" for alternate names", function () use ($key, $sort) {
        $directions = ['ASC' => '+', 'DESC' => '-'];

        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        foreach ($directions as $direction => $operator) {
            $uri = '/api/v1/continents/'.$continent->getKey().'/alternateNames?sort='.$operator.urlencode($sort);

            $request = Request::create(url($uri), 'GET');

            $alternateNamesCollection = AlternateName::query()
                ->byGeonameId($continent->geoname_id)
                ->orderBy($key, $direction)
                ->jsonPaginate(config('json-api-paginate.default_size'));

            $resource = (new PaginatedResourceResponse(
                AlternateNameResource::collection($alternateNamesCollection)
            ));

            getJson($uri)
                ->assertOk()
                ->assertJson(
                    Arr::only($resource->toResponse($request)->getData(true), 'data')
                );
        }
    });
}

test('returns empty data when filters don\'t match for alternate names', function () {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $name = 'invalid';
    $languageCode = 'invalid';

    getJson('/api/v1/continents/'.$continent->getKey().'/alternateNames?filter[languageCode][eq]='.$languageCode.'&filter[name][eq]='.$name)
        ->assertOk()
        ->assertJsonFragment([
            'data' => [],
        ]);
});

test('returns an error response when invalid filter for alternate names', function () use ($alternateNameFilters) {
    $continent = Continent::query()
        ->inRandomOrder()
        ->limit(1)
        ->first();

    $uri = '/api/v1/continents/'.$continent->getKey().'/alternateNames?filter[invalid][eq]=invalid';

    getJson($uri)
        ->assertNotFound()
        ->assertExactJson(
            [
                'errors' => [
                    'message' => 'Requested filter(s) `invalid` are not allowed. Allowed filter(s) are `'.implode(', ', $alternateNameFilters).'`.',
                    'status_code' => Response::HTTP_NOT_FOUND,
                ],
            ]
        );
});

test('returns an error response when invalid include for alternate names', function () {
    $continent = Continent::query()
    ->inRandomOrder()
    ->limit(1)
    ->first();

    $uri = '/api/v1/continents/'.$continent->getKey().'/alternateNames?include=invalid';

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

test('returns an error response when invalid sort for alternate names', function () use ($alternateNameSorts) {
    $continent = Continent::query()
    ->inRandomOrder()
    ->limit(1)
    ->first();

    $uri = '/api/v1/continents/'.$continent->getKey().'/alternateNames?sort=invalid';

    getJson($uri)
        ->assertNotFound()
        ->assertExactJson(
            [
                'errors' => [
                    'message' => 'Requested sort(s) `invalid` is not allowed. Allowed sort(s) are `'.implode(', ', $alternateNameSorts).'`.',
                    'status_code' => Response::HTTP_NOT_FOUND,
                ],
            ]
        );
});
