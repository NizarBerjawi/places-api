<?php

use App\Http\Resources\V1\CountryResource;
use App\Models\Continent;
use App\Models\Country;
use Illuminate\Support\Arr;

class ContinentCountryControllerTest extends TestCase
{
    /** @test */
    public function returnsCorrectStructureOnGetContinentCountries()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/v1/continents/'.$continent->code.'/countries');

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                [
                    'name',
                    'iso3166_alpha2',
                    'iso3166_alpha3',
                    'iso3166_numeric',
                    'population',
                    'area',
                    'phone_code',
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
    public function returnsSuccessResponseOnGetContinentCountries()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/v1/continents/'.$continent->code.'/countries');

        $response->assertResponseOk();
    }

    /** @test */
    public function returnsCorrectPaginationLimitOnGetContinentCountries()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $this->get('/api/v1/continents/'.$continent->code.'/countries');

        $countriesData = json_decode($this->response->getContent(), true);

        $this->assertEquals(
            Arr::get($countriesData, 'meta.per_page'),
            config('geonames.pagination_limit')
        );
    }

    /** @test */
    public function returnsCorrectPaginatedDataOnGetContinentCountries()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $this->get('/api/v1/continents/'.$continent->code.'/countries');

        $countriesCount = Country::query()
            ->byContinent($continent->code)
            ->count();

        $countriesData = json_decode($this->response->getContent(), true);

        if ($countriesCount < config('geonames.pagination_limit')) {
            $this->assertEquals(
                count(Arr::get($countriesData, 'data')),
                $countriesCount
            );
        } else {
            $this->assertEquals(
                count(Arr::get($countriesData, 'data')),
                config('geonames.pagination_limit')
            );
        }

        $this->assertEquals(
            Arr::get($countriesData, 'meta.per_page'),
            config('geonames.pagination_limit')
        );
    }

    /** @test */
    public function returnsNotFoundErrorOnNonExistentContinent()
    {
        $response = $this->get('/api/v1/continents/invalid/countries');

        $response->assertResponseStatus(404);
    }

    /** @test */
    public function returnsCorrectContinentCountries()
    {
        $continent = Continent::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $paginatedCountries = Country::query()
            ->byContinent($continent->code)
            ->simplePaginate(config('geonames.pagination_limit'));

        $response = $this->get('/api/v1/continents/'.$continent->code.'/countries');

        $countriesData = json_decode($this->response->getContent(), true);

        $response->assertEquals(
            CountryResource::collection($paginatedCountries)->resolve(),
            Arr::get($countriesData, 'data')
        );
    }
}
