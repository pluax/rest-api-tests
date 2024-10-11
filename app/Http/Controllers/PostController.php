<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Http\Requests\Post\PostRequest;
use App\Http\Requests\Post\ReviewRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    public function __construct(){
        $this->middleware('auth:sanctum')
            ->only(['store', 'update', 'destroy', 'review', 'show']);

        $this->middleware('post.status')
            ->only(['show']);

    }


    public function index()
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


    public function store(PostRequest $request)
    {
       // dd($request->bearerToken());
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



    public function show(Post $post)
    {

            return [
                "title" => $post->title,
                "body" => $post->body,
                "views" => $post->views,
                "authorName" => $post->user->name,
                "createdAt" => $post->created_at,
                "categoryName" => $post->category->name,
                "comments" => $post->comments->map(fn(Comment $comment) => [
                    "userName" => $comment->user->name,
                    "text" => $comment->text,
                ]),
            ];
    }



    public function update(Post $post, UpdateRequest $request) {

        if ($request->method() === 'PUT') {
            $posts = $post->update([
                'title'         =>  $request->input('title'),
                'body'          =>  $request->input('content'),
                'status'        =>  $request->enum('state', PostStatus::class),
                'category_id'   =>  $request->input('categoryId'),
            ]);
        } else {

            // DTO
            $data = [];

            if ($request->has('title')) {
                $data['title'] = $request->input('title');
            }

            if ($request->has('content')) {
                $data['body'] = $request->input('content');
            }

            if ($request->has('state')) {
                $data['status'] = $request->enum('state', PostStatus::class);
            }

            if ($request->has('categoryId')) {
                $data['category_id'] = $request->input('categoryId');
            }

            $post->update($data);

        }

        return response()->json([
            'status' => 'updated success',
        ], 201);
    }



    public function destroy(Post $post)
    {

        $post->delete();
        return response()->json([
            'status' => 'delete success',
        ]);
    }




    public function review(Post $post, ReviewRequest $request) {

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
