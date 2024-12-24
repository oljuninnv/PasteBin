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
            'id' => $this->id,
            'user' => $this->user?->name,
            'title' => $this->title,
            'content' => $this->content,
            'expires_at' => $this->expires_at,
            'language' => $this->language?->name,
            'category' => $this->category?->name,
            'short_link' => $this->short_link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'visibility' => $this->visibility?->name,
            'expiration_time' => $this->expiration_time?->name,
            'tags' => $this->tags,
        ];
    }
}
