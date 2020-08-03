<?php

namespace App\Http\Middleware;

use Closure;

class JWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() == null)
            return response()->json(['error' => 'Unauthorized'], 401);

        return $next($request);
    }
}
