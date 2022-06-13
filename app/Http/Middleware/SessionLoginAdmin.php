<?php

namespace App\Http\Middleware;

use Closure;

class SessionLoginAdmin
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
        if(!session('SessionLoginAdmin')){
            return redirect('/loginAdmin')->with(['error' => 'You have to login first']);
        }
        return $next($request);
    }
}
