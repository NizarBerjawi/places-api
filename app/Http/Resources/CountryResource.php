<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->only([
            'name',
            'iso3166_alpha2',
            'iso3166_alpha3',
            'population',
            'area', 
            'phone_code'
        ]);
    }
}
