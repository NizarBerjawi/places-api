<?php

use App\Http\Resources\V1\ContinentResource;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;
use Illuminate\Support\Arr;

class CountryControllerTest extends TestCase
{
    /** @test */
    public function returnsCorrectStructureOnGetCountries()
    {
        $response = $this->get('/api/v1/countries');

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                [
                    'name',
                    'iso3166Alpha2',
                    'iso3166Alpha3',
                    'iso3166Numeric',
                    'population',
                    'area',
                    'phoneCode',
                ],
            ],
            'links' => [
                'first',
                'last',
                'next',
                'prev',
            ],
            'meta' => [
                'currentPage',
                'from',
                'path',
                'perPage',
                'to',
            ],
        ]);
    }

    /** @test */
    public function returnsSuccessResponseOnGetCountries()
    {
        $response = $this->get('/api/v1/countries');

        $response->assertResponseOk();
    }

    /** @test */
    public function returnsCorrectPaginationLimitOnGetCountries()
    {
        $this->get('/api/v1/countries');

        $countriesData = json_decode($this->response->getContent(), true);

        $this->assertEquals(
            Arr::get($countriesData, 'meta.perPage'),
            config('geonames.pagination_limit')
        );
    }

    /** @test */
    public function returnsCorrectPaginatedDataOnGetCountries()
    {
        $this->get('/api/v1/countries');

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
            Arr::get($countriesData, 'meta.perPage'),
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

        $response = $this->get('/api/v1/countries/'.$country->iso3166_alpha2);

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                'name',
                'iso3166Alpha2',
                'iso3166Alpha3',
                'iso3166Numeric',
                'population',
                'area',
                'phoneCode',
            ],
        ]);
    }

    /** @test */
    public function returnsNotFoundErrorOnNonExistentCountry()
    {
        $response = $this->get('/api/v1/countries/invalid');

        $response->assertResponseStatus(404);
    }

    /** @test */
    public function returnsCorrectStructureAndDataOnShowCountry()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/v1/countries/'.$country->iso3166_alpha2);

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => CountryResource::make($country)->resolve(),
        ]);
    }

    /** @test */
    public function returnsCorrectCountryByCode()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/v1/countries?filter[iso3166Alpha2]='.$country->iso3166_alpha2);

        $response->shouldReturnJson();
        $response->seeJsonContains([
            'data' => CountryResource::collection(
                Arr::wrap($country)
            )->resolve(),
        ]);
    }

    /** @test */
    public function returnsCountriesWithContinent()
    {
        $response = $this->get('/api/v1/countries?include=continent');

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                [
                    'name',
                    'iso3166Alpha2',
                    'iso3166Alpha3',
                    'iso3166Numeric',
                    'population',
                    'area',
                    'phoneCode',
                    'continent',
                ],
            ],
            'links' => [
                'first',
                'last',
                'next',
                'prev',
            ],
            'meta' => [
                'currentPage',
                'from',
                'path',
                'perPage',
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

        $response = $this->get('/api/v1/countries/'.$country->iso3166_alpha2.'?include=continent');

        $response->shouldReturnJson();
        $response->seeJsonEquals([
            'data' => CountryResource::make($country)->resolve() + [
                    'continent' => ContinentResource::make($country->continent),
                ],
        ]);
    }
}
