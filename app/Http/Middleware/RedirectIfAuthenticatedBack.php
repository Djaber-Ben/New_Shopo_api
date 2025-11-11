<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedBack
{
    public function handle($request, Closure $next)
    {
        // If admin is already logged in, prevent showing login page again
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
