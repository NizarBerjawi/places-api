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
            'filename' => $this->filename,
            'url' => route('flags', ['flag' => $this->filename]),
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
