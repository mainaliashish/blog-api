<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPostAuthorOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the post ID from the route parameter (assuming route is like 'posts/{post}')
        $postId = $request->route('post');

        $post = Post::find($postId['id']);

        if ($post->author_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'You are not authorized to update this post'], 403);
        }

        return $next($request);
    }
}
