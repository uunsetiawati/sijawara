<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class AdminAccess
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
        if (JWTAuth::user()->level != 'admin') {
            return \App\Helpers\RestApi::error('You don\'t have permissions.', 400);
        }
        
        return $next($request);
    }
}
