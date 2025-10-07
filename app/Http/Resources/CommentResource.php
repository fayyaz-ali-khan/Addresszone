<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Comment */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'user_id' => $this->user_id,
            'author' => new UserResource($this->whenLoaded('user')),
            'blog_id' => $this->blog_id,
            'blog' => new BlogResource($this->whenLoaded('blog')),
            'created_at' => $this->created_at->format('d M, Y'),
        ];
    }
}
