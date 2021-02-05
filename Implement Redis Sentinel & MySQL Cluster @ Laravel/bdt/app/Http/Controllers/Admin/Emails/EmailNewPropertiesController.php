<?php

namespace App\Http\Controllers\Admin\Emails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewPropertiesEmailable;
use App\Models\Agent;
use App\Models\Property;

class EmailNewPropertiesController extends Controller
{
    //
    public function index(Request $request){
    	$users = Agent::select('name','email')->get();
    	$props = Property::find($request->propsid);
        # Optimizing server's (?)
        # Apply delay 50 emails per minute, change $email_permins to change it
        # Default val is 50 so 50-59 delayed 1 mins , 100-149 delayed 2 mins
        $email_permins = 50;
    	foreach ($users as $key => $user) {
    		
            $delay = $key / $email_permins; 
    		$url = Route('listing.property.show',['id'=> $request->propsid]);
    		Mail::to($user->email)->later(now()->addMinutes($delay),new SendNewPropertiesEmailable($url,$user->name,$props));
    	}

        return redirect()->back()->with('success','Data property berhasil disimpan');

    }
}
