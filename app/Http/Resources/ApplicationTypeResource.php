<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'eha_component_id' => $this->eha_component_id, 
            'eha_component_name' => $this->ehaComponent ? $this->ehaComponent->name : null,
            'eha_component' => new EhaComponentResource($this->whenLoaded('ehaComponent')),  
        ];
    }
}
