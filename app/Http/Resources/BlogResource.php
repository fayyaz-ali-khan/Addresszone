<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->when($request->routeIs('blogs.show'), $this->body),
            'image' => asset('storage/' . $this->image),
            'created_at' => $this->created_at->format('d M, Y'),
            'blog_category_id' => $this->blog_category_id,
            'category' => BlogCategoryResource::make($this->whenLoaded('category')),
            'author' => UserResource::make($this->whenLoaded('author')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'comments_count' => $this->whenCounted('comments'),
        ];
    }
}
