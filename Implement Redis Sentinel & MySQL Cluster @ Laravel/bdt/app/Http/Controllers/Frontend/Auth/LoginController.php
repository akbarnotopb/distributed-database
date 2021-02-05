<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
      return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
      $request->validate([
        'email' => 'required|email',
        'password' => 'required'
      ]);

      $agent = @Agent::where('email', $request->email)->where('plain_text_password', $request->password)->first();
      if($agent){
        $agent->password              =   bcrypt($student->plain_text_password);
        $agent->plain_text_password   =   null;
        $agent->save();
      }

      $user = \Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
      ]);

      if (!$user) {
        // return response()->json(['message' => 'Gagal login, email atau password anda salah.', 'errors' => []], 401);
        return redirect()->back()->withInput()->withErrors(['message' => 'Gagal login, email atau password anda salah.']);
      }

      return redirect()->route('dashboard.index');
    }

    public function logout()
    {
      \Auth::logout();

      return redirect()->route('agents.auth.login');
    }
}
