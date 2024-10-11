<?php

namespace App\Http\Resources\Post;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Post
 */

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"        => $this->title,
            "body"         => $this->body,
            "views"        => $this->views,
            "authorName"   => $this->user->name,
            "createdAt"    => $this->created_at,
            "categoryName" => $this->category->name,
            "comments"     => PostCommentResource::collection($this->comments),
        ];
    }
}
