<?php

namespace App\Http\Middleware\Agent;

use Closure;

class CheckIfTheAgentIsApproved
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
            // 'frontend.welcome', 'agents.auth.register'
            "agents.auth.pending"
        ]);
        

        if (auth()->check() and auth()->user()->isApprovedAgent() and !$routeExceptions->contains($request->route()->getName())) {
            return redirect()->route('agents.auth.pending')->with('warning-not-approved', 'Hai Agent, silahkan menunggu akun kamu diaktifkan!');
        }
        else if(auth()->check() and !auth()->user()->isApprovedAgent() and  $routeExceptions->contains($request->route()->getName())){
            return redirect()->route("dashboard.index");
        }

        return $next($request);
    }
}
