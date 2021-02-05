<?php

namespace App\Http\Controllers\Admin\Emails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerifiedNotificationEmailable;
use App\Models\Agent;

class EmailVerifiedNotificationController extends Controller
{
    //

    public function index(Request $request){
    	$user = Agent::find($request->userid);
    	Mail::to($user->email)->queue(new SendVerifiedNotificationEmailable($user->name));

        return redirect()->route('agents.index')->with('message','Berhasil mengedit data');
    }
}
