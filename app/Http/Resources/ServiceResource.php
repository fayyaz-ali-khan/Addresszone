<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'service_category_id' => $this->service_category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'months' => $this->months,
            'description' => $this->description,
            'image' => asset('storage/'.$this->image),
            'category' => new ServiceCategoryResource($this->whenLoaded('category')),
        ];
    }
}
