<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Agent\StoreNewAgent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    public function index(Request $request)
  	{
  		if(auth()->check() AND auth()->user()->approved == 1)
  		{
  			return redirect()->route('dashboard.index');
  		}
	    return view('frontend.auth.register');
  	}

  	public function store(StoreNewAgent $request)
  	{

  		$data = [
	      'name' => $request->firstname.' '.$request->lastname,
	      'email' => $request->email,
	      'approved' => 0,
	      'password' => bcrypt($request->password)
	    ];

	    $agent = \App\Models\Agent::create($data);

	    \Auth::guard('agents')->login($agent);

	    return redirect()->route('agents.auth.register');
  	}
}
