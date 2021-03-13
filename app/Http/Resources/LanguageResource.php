<?php

namespace App\Http\Resources;

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
            'name'      => $this->name,
            'iso639_1'  => $this->iso639_1,
            'iso639_2'  => $this->iso639_2,
            'iso639_3'  => $this->iso639_3
        ];
    }
}
