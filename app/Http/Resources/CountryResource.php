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
        return [
            'name'            => $this->name,
            'iso3166_alpha2'  => $this->iso3166_alpha2,
            'iso3166_alpha3'  => $this->iso3166_alpha3,
            'iso3166_numeric' => $this->iso3166_numeric,
            'population'      => $this->population,
            'area'            => $this->area,
            'phone_code'      => $this->phone_code,
            'continent'       => ContinentResource::make($this->whenLoaded('continent')),
            'time_zones'      => TimeZoneResource::collection($this->whenLoaded('timeZones')),
            'flag'            => FlagResource::make($this->whenLoaded('flag')),
            'neighbours'     => self::collection($this->whenLoaded('neighbours')),
        ];
    }
}
