<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Enums\PostStatus;
class PostController extends Controller
{
    //
    public function list()
    {
        $posts = Post::query()
            ->select(['id', 'title', 'thumbnail', 'views', 'created_at'])
            ->whereStatus(PostStatus::Published)
            ->get();


        return $posts->map(fn(Post $posts) => [
            "title"     => $posts->title,
            "thumbnail" => $posts->thumbnail,
            "views"     => $posts->views,
            "createdAt" => $posts->created_at,
        ]);
    }



    public function show(Post $post)
    {

        if ($post->status !== PostStatus::Published) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        return [
            "title"        => $post->title,
            "body"         => $post->body,
            "views"        => $post->views,
            "authorName"   => $post->user->name,
            "createdAt"    => $post->created_at,
            "categoryName" => $post->category->name,
            "comments"     => $post->comments->map(fn (Comment $comment) => [
                    "userName" => $comment->user->name,
                    "text"     => $comment->text,
             ]),
        ];
    }
}
