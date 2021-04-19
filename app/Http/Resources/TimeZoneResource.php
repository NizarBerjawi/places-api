<?php

namespace App\Http\Resources;

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
            'code'       => $this->code,
            'time_zone'  => $this->time_zone,
            'gmt_offset' => $this->gmt_offset,
            'country'    => new CountryResource($this->whenLoaded('country')),
        ];
    }
}
