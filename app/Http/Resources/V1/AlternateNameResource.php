<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AlternateNameResource extends JsonResource
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
            'name'              => $this->name,
            'language'          => LanguageResource::make($this->whenLoaded('language')),
            'place'             => PlaceResource::make($this->whenLoaded('place')),
            'is_preferred_name' => $this->is_preferred_name,
            'is_short_name'     => $this->is_short_name,
        ];
    }
}
