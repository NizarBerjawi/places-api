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
            'code'              => $this->code,
            'short_description' => $this->short_description,
            'full_description'  => $this->full_description,
            'feature_class'     => FeatureClassResource::make($this->whenLoaded('featureClass')),
        ];
    }
}
