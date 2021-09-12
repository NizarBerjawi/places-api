<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'geonameId'   => $this->geoname_id,
            'name'        => $this->name,
            'population'  => $this->population,
            'elevation'   => $this->elevation,
            'timeZone'    => TimeZoneResource::make($this->whenLoaded('timeZone')),
            'featureCode' => FeatureCodeResource::make($this->whenLoaded('featureCode')),
            'country'     => CountryResource::make($this->whenLoaded('country')),
            'location'    => LocationResource::make($this->whenLoaded('location')),
        ];
    }
}
