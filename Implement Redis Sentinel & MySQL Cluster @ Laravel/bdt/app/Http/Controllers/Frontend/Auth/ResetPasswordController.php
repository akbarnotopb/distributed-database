<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use App\Models\Agent;
class ResetPasswordController extends Controller
{
    //
    use ResetsPasswords;

    protected $redirectTo='/';

    public function broker(){
    	return Password::broker('agents');
    }

    public function showResetForm(Request $request , $token=null,$email=null){
    	// dd(decrypt($email));
    	return view('frontend.auth.password-reset')
    			->with(['token' => $token, 'email' => decrypt($email)]);
    }

    public function reset(Request $request){
    	// dd($request);
    	$request->validate(
    		[
    			'password'=>'required|confirmed|min:6',
    			],
    		[
    			'password.confirmed'=>"Password tidak sama!",
    			'password.min' => "Password minimal 6 digit!"
    			]
    	);

    	// dd($request);

 		$update=Agent::where(['email'=>$request->email])->first();
 		// dd($update);
 		$update->password=bcrypt($request->password);
 		$update->save();
 		// event(new PasswordReset($user));
 		$this->guard()->login($update);
 		return redirect()->route('dashboard.index');
    }

    public function guard(){
    	return \Auth::guard('agents');
    }
}
