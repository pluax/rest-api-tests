<?php

namespace App\Http\Middleware;

use App\Enums\PostStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StatusPostMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {

       $post = $request->route('post');

        if ($post->status !== PostStatus::Published) {
            $author_id = $post->user->id;
            $auth_id = auth()->user()->id;

            if ($author_id !== $auth_id) {

                return response()->json([
                    'message' => 'not permitted or allowed',
                ], 403);

            }

        }

        return $next($request);
    }
}
