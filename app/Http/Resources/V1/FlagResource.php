<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FlagResource extends JsonResource
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
            'country_code' => $this->country_code,
            'path'         => url($this->path),
            'country'      => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
