<?php

namespace App\Http\Resources\V1;

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
        return [
            'name' => $this->name,
            'iso3166Alpha2' => $this->iso3166_alpha2,
            'iso3166Alpha3' => $this->iso3166_alpha3,
            'iso3166Numeric' => $this->iso3166_numeric,
            'population' => $this->population,
            'area' => $this->area,
            'phoneCode' => $this->phone_code,
            'topLevelDomain' => $this->top_level_domain,
            'location' => LocationResource::make($this->whenLoaded('location')),
            'currency' => CurrencyResource::make($this->whenLoaded('currency')),
            'continent' => ContinentResource::make($this->whenLoaded('continent')),
            'flag' => FlagResource::make($this->whenLoaded('flag')),
            'timeZones' => TimeZoneResource::collection($this->whenLoaded('timeZones')),
            'neighbours' => self::collection($this->whenLoaded('neighbours')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
            'alternateNames' => AlternateNameResource::collection($this->whenLoaded('alternateNames')),
        ];
    }
}
