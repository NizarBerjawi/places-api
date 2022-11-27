<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
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
            'iso639.1' => $this->iso639_1,
            'iso639.2' => $this->iso639_2,
            'iso639.3' => $this->iso639_3,
            'countries' => CountryResource::collection(
                $this->whenLoaded('countries')
            ),
        ];
    }
}
