<?php

namespace App\Http\Resources\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin \App\Models\Product
 */
class MinifiedPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"     => $this->title,
            "thumbnail" => $this->thumbnail,
            "views"     => $this->views,
            "createdAt" => $this->created_at,
        ];

    }
}
