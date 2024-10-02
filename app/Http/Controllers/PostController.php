<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\PostStatus;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    //

    public function __construct(){
        auth()->login(User::first());
    }


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


    public function add(Request $request) {

        $path = $request->file('thumbnail')->storePublicly('images');

        $posts = auth()->user()->posts()->create([
            'title'         => $request->str('title'),
            'body'          => $request->str('content'),
            'thumbnail'     => config('app.url').Storage::url($path),
            'status'        => $request->enum('state', PostStatus::class),
            'category_id'   => $request->integer('categoryId'),

        ]);


        return response()->json([
            'id' => $posts->id,
        ], 201);

    }



    public function review(Post $post, Request $request) {

        $user = auth()->id();

        $review = $post->comments()->create([
            'user_id'   => $user,
            'text'      => $request->str('text'),

        ]);


        return response()->json([
            'id' => $review->id,
        ], 201);

    }


}
