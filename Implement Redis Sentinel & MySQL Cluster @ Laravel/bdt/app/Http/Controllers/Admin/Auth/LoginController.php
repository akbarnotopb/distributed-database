<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function loginForm()
  	{
    	return view('admin.auth.login');
  	}

  	public function login(Request $request)
	{
	    $loginWithUsername = auth()->guard('admin')->attempt(
	      $request->only(['username', 'password']),
	      $request->input('remember')
	    );

	    $loginWithEmail = auth()->guard('admin')->attempt([
	      'email' => $request->username,
	      'password' => $request->password
	    ], $request->input('remember'));

	    if ($loginWithUsername || $loginWithEmail) {
	      return redirect()->route('admin.index');
	    }

	    return redirect()->intended('/admin-area');
	}

	public function logout()
  	{
    	auth()->guard('admin')->logout();

    	return redirect()->route('admin.auth.login');
  	}
}
