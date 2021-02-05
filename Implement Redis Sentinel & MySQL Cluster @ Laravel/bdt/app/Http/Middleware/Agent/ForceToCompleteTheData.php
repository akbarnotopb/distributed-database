<?php

namespace App\Http\Middleware\Agent;

use Closure;

class ForceToCompleteTheData
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
        $routeExceptions = collect([
            'settings.account.edit', 'settings.account.update', 'frontend.welcome'
        ]);

        if (auth()->check() and !auth()->user()->isApprovedAgent() and auth()->user()->isNeededToCompleteData() and !$routeExceptions->contains($request->route()->getName())) {
            return redirect()->route('settings.account.edit')->with('warning', 'Hai Agent, silahkan lengkapi profil terlebih dahulu!');
        }

        return $next($request);
    }
}
