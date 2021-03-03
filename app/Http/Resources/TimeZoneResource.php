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
            'gmt_offset' => $this->gmt_offset,
            'countries'  => new CountryResource($this->whenLoaded('country'))
        ];
    }
}
