<?php

namespace App\Http\Controllers\Frontend\Dashboard\Profiles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Downline;
class ProfileController extends Controller
{
    public function index()
    {
        $agent = auth()->user();
        return view('frontend.dashboard.profiles.index', compact(
            'agent'));
    }
    public function member(){
        $downline = Agent::select('agents.name as name','agents.phone_number as phone_number' , 'agents.approved as approved', 'agents.email as email')
        ->join('downline','downline.downline','=','agents.id')
        ->where('downline.upline',auth()->user()->id)
        ->get();

    	return view('frontend.dashboard.profiles.member',compact('downline'));
    }
}
