<?php

use App\Models\Continent;
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

    $continentsCount = Continent::count();
    // $continentsData = json_decode($>response->getContent(), true);

    if ($continentsCount < config('geonames.pagination_limit')) {
        $this->assertEquals(
            count(Arr::get($response, 'data')),
            $continentsCount
        );
    } else {
        $this->assertEquals(
            count(Arr::get($response, 'data')),
            config('geonames.pagination_limit')
        );
    }

    $this->assertEquals(
        Arr::get($response, 'meta.per_page'),
        config('geonames.pagination_limit')
    );
});
