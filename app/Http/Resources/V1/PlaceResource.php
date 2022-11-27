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
            'geonameId' => $this->geoname_id,
            'name' => $this->name,
            'asciiName' => $this->ascii_name,
            'population' => $this->population,
            'elevation' => $this->elevation,
            'dem' => $this->dem,
            'alternateNames' => AlternateNameResource::collection($this->whenLoaded('alternateNames')),
            'timeZone' => TimeZoneResource::make($this->whenLoaded('timeZone')),
            'featureCode' => FeatureCodeResource::make($this->whenLoaded('featureCode')),
            'featureClass' => FeatureClassResource::make(
                $this->whenLoaded('featureClass', $this->featureClass()->first())
            ),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'location' => LocationResource::make($this->whenLoaded('location')),
        ];
    }
}
