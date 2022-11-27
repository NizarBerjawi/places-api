<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureCodeResource extends JsonResource
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
            'shortDescription' => $this->short_description,
            'fullDescription' => $this->full_description,
            'featureClass' => FeatureClassResource::make($this->whenLoaded('featureClass')),
        ];
    }
}
