<?php

use App\Http\Resources\ContinentResource;
use App\Http\Resources\CountryResource;
use App\Models\Continent;
use App\Models\Country;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CountryControllerTest extends TestCase
{
    /** @test */
    public function returnsCorrectStructureOnGetCountries()
    {
        $response = $this->get('/api/countries');

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
    public function returnsSuccessResponseOnGetCountries()
    {
        $response = $this->get('/api/countries');

        $response->assertResponseOk();
    }

    /** @test */
    public function returnsCorrectPaginationLimitOnGetCountries()
    {
        $this->get('/api/countries');

        $countriesData = json_decode($this->response->getContent(), true);

        $this->assertEquals(
            Arr::get($countriesData, 'meta.per_page'),
            config('geonames.pagination_limit')
        );
    }

    /** @test */
    public function returnsCorrectPaginatedDataOnGetCountries()
    {
        $this->get('/api/countries');

        $countriesCount = Country::count();
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
    public function returnsCorrectStructureOnShowCountry()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/countries/'.$country->iso3166_alpha2);

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                'name',           
                'iso3166_alpha2', 
                'iso3166_alpha3', 
                'iso3166_numeric',
                'population',     
                'area',           
                'phone_code',     
            ],
        ]);
    }

    /** @test */
    public function returnsNotFoundErrorOnNonExistentCountry()
    {
        $response = $this->get('/api/countries/invalid');

        $response->assertResponseStatus(404);
    }

    /** @test */
    public function returnsCorrectStructureAndDataOnShowCountry()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/countries/'.$country->iso3166_alpha2);

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => CountryResource::make($country)->resolve()
        ]);
    }

    /** @test */
    public function returnsCorrectCountryByCode()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/countries?filter[iso3166_alpha2]='.$country->iso3166_alpha2);

        $response->shouldReturnJson();
        $response->seeJsonContains([
            'data' => CountryResource::collection(
                Arr::wrap($country)
            )->resolve()
        ]);
    }

    /** @test */
    public function returnsCountriesWithContinent()
    {
        $response = $this->get('/api/countries?include=continent');

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
                    'continent'
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
    public function returnsCountriesWithCorrectContinent()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/countries/'.$country->iso3166_alpha2.'?include=continent');

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => 
                CountryResource::make($country)->resolve() + [
                    'continent' => ContinentResource::make($country->continent)
                ]
        ]);
    }
}
