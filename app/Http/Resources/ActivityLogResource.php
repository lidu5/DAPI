<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user'       => $this->user,
            'type'       => $this->type,
            'remarks'    => $this->remarks,
            'created_at' => $this->created_at,
        ];
    }
}
