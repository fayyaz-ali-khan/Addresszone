<?php

namespace App\Http\Resources;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin BlogCategory */
class BlogCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'description' => $this->description,
            'slug' => $this->slug,
            'name' => $this->name,
            'id' => $this->id,
            'blogs_count' => $this->blogs_count,
            'blogs' => BlogResource::collection($this->whenLoaded('blogs')),
        ];
    }
}
