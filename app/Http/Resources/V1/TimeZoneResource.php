<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TimeZoneResource extends JsonResource
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
            'code' => $this->code,
            'timeZone' => $this->time_zone,
            'gmtOffset' => $this->gmt_offset,
            'country' => new CountryResource($this->whenLoaded('country')),
        ];
    }
}
