<?php

namespace App\Http\Middleware;

use Closure;

class AdvanceMiddleware
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
        if (auth()->check() && auth()->user()->rol == 'Administrador' || auth()->check() && auth()->user()->rol == 'Jefe')
            return $next($request);
            
        return $next($request);
    }
}
