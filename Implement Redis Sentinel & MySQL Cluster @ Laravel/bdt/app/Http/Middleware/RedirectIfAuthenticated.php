<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (!$guard) {
            $guard = config('auth.defaults.guard');
        }

        if ($guard === 'agents' and auth()->guard($guard)->check()) {
            return redirect()->route('dashboard.index');
        } elseif ($guard === 'admin' and auth()->guard($guard)->check()) {
            return redirect()->route('admin.index');
        }

        return $next($request);
    }
}
