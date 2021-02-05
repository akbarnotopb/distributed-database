<?php

namespace App\Http\Middleware\Marketplace;

use Closure;
use App\Models\Agent;
class ReferalCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   //if not exist return to homepage marketplace
        if($request->route('username')=='admin-area'){
            return redirect()->route('admin.index');
        }
        if($request->route('username')){
            $agent_existed=Agent::where(['username'=>$request->route('username')])->first();
            if(!isset($agent_existed)){
                return redirect()->route('marketplace.index');
            }
        }
        return $next($request);
    }
}
