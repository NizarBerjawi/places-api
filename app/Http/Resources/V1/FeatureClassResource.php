<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureClassResource extends JsonResource
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
            'description' => $this->description,
            'featureCodes' => FeatureCodeResource::collection($this->whenLoaded('featureCodes')),
        ];
    }
}
