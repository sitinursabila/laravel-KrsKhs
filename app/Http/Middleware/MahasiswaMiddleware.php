<?php

namespace App\Http\Middleware;

use Closure;

class MahasiswaMiddleware
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
        if (Auth::user()->role != "user") {
            return redirect('logout');

        }
        return $next($request);
        return $next($request);
    }
}
