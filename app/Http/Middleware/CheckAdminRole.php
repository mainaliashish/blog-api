<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = [
            'success' => false,
            'status' => 403,
            'message' => 'You are not authorized to delete this post',
        ];
        if (Auth::user()->role !== 'admin') {
            return response()->json($response, 403);
        }

        return $next($request);
    }
}
