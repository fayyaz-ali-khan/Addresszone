<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'user_id' => new UserResource($this->whenLoaded('user')),
            'document_title' => $this->document_title,
            'document_file' => asset('storage/' . $this->document_file),
            'status' => $this->status,
            'created_by' => new UserResource($this->whenLoaded('creator')),
            'updated_by' => new UserResource($this->whenLoaded('updater')),
            'created_at' => $this->created_at->format('d/m/Y h:i A')

        ];
    }
}
