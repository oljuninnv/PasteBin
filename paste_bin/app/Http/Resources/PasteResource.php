<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PasteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user' => $this->resource->user?->name,
            'title' => $this->resource->title,
            'content' => $this->resource->content,
            'expires_at' => $this->resource->expires_at,
            'language' => $this->resource->language?->name,
            'category' => $this->resource->category?->name,
            'short_link' => $this->resource->short_link,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'visibility' => $this->resource->visibility?->name,
            'expiration_time' => $this->resource->expiration_time?->name,
            'tags' => $this->resource->tags,
        ];
    }
}