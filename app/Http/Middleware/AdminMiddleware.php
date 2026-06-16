<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Silakan login terlebih dahulu'
            ], 401);
        }

        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak, hanya untuk admin'
            ], 403);
        }

        return $next($request);
    }
}