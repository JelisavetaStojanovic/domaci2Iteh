<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'client';
    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'last_name' => $this->resource->last_name,
            'weight' => $this->resource->weight,
            'height' => $this->resource->height,
            'city' => new CityResource($this->resource->city)
        ];
    }
}
