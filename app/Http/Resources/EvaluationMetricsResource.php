<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationMetricsResource extends JsonResource
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
            'elements' => $this->elements,
            'weight' => $this->weight,
            'evaluation_metrics_category_id' => $this->evaluation_metrics_category_id, 
            'category_name' => $this->category ? $this->category->name : null,
            'category' => new EvaluationMetricsCategoryResource($this->whenLoaded('category')),  
        ];
    }
}

