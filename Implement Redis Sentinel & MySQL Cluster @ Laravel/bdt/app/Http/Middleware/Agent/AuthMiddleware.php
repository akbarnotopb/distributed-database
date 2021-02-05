<?php

namespace App\Http\Middleware\Agent;

use Closure;

class AuthMiddleware
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
        if (!\Auth::guard('agents')->check()) {
            return redirect()->route('agents.auth.login');
        }
        return $next($request);
    }
}
