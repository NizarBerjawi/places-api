<?php

use App\Http\Resources\CountryResource;
use App\Models\Continent;
use Illuminate\Support\Arr;

class ContinentControllerTest extends TestCase
{
    /** @test */
    public function returnsCorrectStructureOnGetContinents()
    {
        $response = $this->get('/api/continents');

        $response->shouldReturnJson();
        $response->assertResponseOk();
        $response->seeJsonStructure([
            'data' => [
                [
                    'code',
                    'name',
                ],
            ],
            'links' => [
                'first',
                'last',
                'next',
                'prev',
            ],
            'meta' => [
                'current_page',
                'from',
                'path',
                'per_page',
                'to',
            ],
        ]);
    }

    /** @test */
    public function returnsSuccessResponseOnGetContinents()
    {
        $response = $this->get('/api/continents');

        $response->assertResponseOk();
    }

    /** @test */
    public function returnsCorrectPaginationLimitOnGetContinents()
    {
        $this->get('/api/continents');

        $continentsData = json_decode($this->response->getContent(), true);

        $this->assertEquals(
            Arr::get($continentsData, 'meta.per_page'),
            config('geonames.pagination_limit')
        );
    }

    /** @test */
    public function returnsCorrectPaginatedDataOnGetContinents()
    {
        $this->get('/api/continents');

        $continentsCount = Continent::count();
        $continentsData = json_decode($this->response->getContent(), true);

        if ($continentsCount < config('geonames.pagination_limit')) {
            $this->assertEquals(
                count(Arr::get($continentsData, 'data')),
                $continentsCount
            );
        } else {
            $this->assertEquals(
                count(Arr::get($continentsData, 'data')),
                config('geonames.pagination_limit')
            );
        }

        $this->assertEquals(
            Arr::get($continentsData, 'meta.per_page'),
            config('geonames.pagination_limit')
        );
    }

    /** @test */
    public function returnsCorrectContinentOnShowContinent()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/continents/'.$continent->code);

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => [
                'code' => $continent->code,
                'name' => $continent->name,
            ],
        ]);
    }

    /** @test */
    public function returnsNotFoundErrorOnNonExistentContinent()
    {
        $response = $this->get('/api/continents/invalid');

        $response->assertResponseStatus(404);
    }

    /** @test */
    public function returnsCorrectStructureAndDataOnShowContinent()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/continents/'.$continent->code);

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => [
                'code' =>  $continent->code,
                'name' => $continent->name,
            ],
        ]);
    }

    /** @test */
    public function returnsCorrectContinentByCode()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/continents?filter[code]='.$continent->code);

        $response->shouldReturnJson();
        $response->seeJsonContains([
            'data' => [[
                'code' => $continent->code,
                'name' => $continent->name,
            ]],
        ]);
    }

    /** @test */
    public function returnsCorrectContinentByName()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/continents?filter[name]='.$continent->name);

        $response->shouldReturnJson();
        $response->seeJsonContains([
            'data' => [[
                'code' => $continent->code,
                'name' => $continent->name,
            ]],
        ]);
    }

    /** @test */
    public function returnEmptyDataSetWhenFiltersDontMatch()
    {
        $continents = Continent::query()
            ->inRandomOrder()
            ->limit(2)
            ->get();

        $response = $this->get('/api/continents?filter[code]='.$continents->first()->code.'&filter[name]='.$continents->last()->name);

        $response->shouldReturnJson();
        $response->seeJsonContains([
            'data' => [],
        ]);
    }

    /** @test */
    public function returnsContinentsWithCountry()
    {
        $response = $this->get('/api/continents?include=countries');

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                [
                    'code',
                    'name',
                    'countries',
                ],
            ],
            'links' => [
                'first',
                'last',
                'next',
                'prev',
            ],
            'meta' => [
                'current_page',
                'from',
                'path',
                'per_page',
                'to',
            ],
        ]);
    }

    /** @test */
    public function returnsContinentWithCorrectCountries()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/continents/'.$continent->code.'?include=countries');

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => [
                'code' =>  $continent->code,
                'name' => $continent->name,
                'countries' => CountryResource::collection($continent->countries),
            ],
        ]);
    }
}
