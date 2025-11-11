<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        // 👇 Fix Sanctum issue — return JSON instead of redirect
        if (! $request->expectsJson()) {
            abort(response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401));
        }
    }
}
