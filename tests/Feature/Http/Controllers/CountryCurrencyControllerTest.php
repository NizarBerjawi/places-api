<?php

use App\Http\Resources\V1\CurrencyResource;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Arr;

class CountryCurrencyControllerTest extends TestCase
{
    /** @test */
    public function returnsCorrectStructureOnGetCountryCurrency()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/v1/countries/'.$country->iso3166_alpha2.'/currency');

        $response->shouldReturnJson();
        $response->seeJsonStructure([
            'data' => [
                    'code',
                    'name',
            ],
        ]);
    }

    /** @test */
    public function returnsSuccessResponseOnGetCountryCurrency()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $response = $this->get('/api/v1/countries/'.$country->iso3166_alpha2.'/currency');

        $response->assertResponseOk();
    }

    /** @test */
    public function returnsNotFoundErrorOnNonExistentCountry()
    {
        $response = $this->get('/api/v1/countries/invalid/currency');

        $response->assertResponseStatus(404);
    }

    /** @test */
    public function returnsCorrectCountryCurrency()
    {
        $country = Country::query()
            ->inRandomOrder()
            ->limit(1)
            ->first();

        $currency = Currency::query()
            ->byCountry($country->iso3166_alpha2)
            ->first();

        $response = $this->get('/api/v1/countries/'.$country->iso3166_alpha2.'/currency');

        $currencyData = json_decode($this->response->getContent(), true);

        $response->assertEquals(
            CurrencyResource::make($currency)->resolve(),
            Arr::get($currencyData, 'data')
        );
    }
}
