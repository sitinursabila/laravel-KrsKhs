<?php

namespace App\Http\Middleware;

use Closure;

class SessionLogin
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
        if(!session('SessionLogin')){
            return redirect('/user')->with(['error' => 'You have to login first']);
        }
        return $next($request);
    }
}
