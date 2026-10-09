<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoverageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'num_clients' => $this->pivot->num_clients,
            'num_hw_facilities' => $this->pivot->num_hw_facilities,
            'num_hw_users' => $this->pivot->num_hw_users
        ];
    }
}
