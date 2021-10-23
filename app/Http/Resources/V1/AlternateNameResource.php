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
            'name'            => $this->name,
            'isPreferredName' => $this->is_preferred_name,
            'isShortName'     => $this->is_short_name,
            'isHistoric'      => $this->is_historic,
            'isColloquial'    => $this->is_colloquial,
            'language'        => LanguageResource::make($this->whenLoaded('language')),
            'place'           => PlaceResource::make($this->whenLoaded('place')),
        ];
    }
}
