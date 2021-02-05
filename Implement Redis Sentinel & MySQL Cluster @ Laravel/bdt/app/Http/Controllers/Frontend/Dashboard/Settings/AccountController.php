<?php

namespace App\Http\Controllers\Frontend\Dashboard\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Agent\SettingAccountRequest;
use Illuminate\Support\Facades\File;
use App\Models\Downline;
use App\Models\Agent;

class AccountController extends Controller
{
    function __construct()
    {
        view()->share('activeMenu', 'settings');
        view()->share('activeSubMenu', 'account');
    }

    public function edit()
    {
        $downlines=[];
        $agent = auth()->user();
        $downid=Downline::select('upline','downline')->where('upline','=',$agent->id)->get(); 
        foreach ($downid as $key => $value) {
             array_push($downlines,$value->downline);
         } 
        $_agents = Agent::select('id','name')->where('id','!=',$agent->id)->where('approved','=',1)->whereNotIn('id',$downlines)->get();
        return view('frontend.dashboard.settings.account', compact(
            'agent'
        ))->with('_agents', $_agents);
    }

    public function update(SettingAccountRequest $request)
    {
        $agent = auth()->user();
        if (@$request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $realImage = file_get_contents($image->getRealPath());
            $name = explode("@", $request->input('email'))[0];
            $avatarName = $name.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $path = "/storage/avatars/{$avatarName}";
            File::put(public_path().$path, $realImage);

            $agent->update([
                'photo' => $path
            ]);
        }

        $old_upline = $agent->upline;
        // dd($request->username);
        // dd($agent);
        $agent->update([
            'name' => $request->firstname.' '.$request->lastname,
            'email' => $request->email,
            'upline' => (is_null($request->upline))?$agent->upline:$request->upline,
            'username' => (isset($request->username))?$request->username:$agent->username,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'nik' => $request->nik,
            'bank_name' => $request->bank_name,
            'bank_customer' => $request->bank_customer,
            'bank_account' => $request->bank_account,
            'whatsapp' =>$request->whatsapp
        ]);

        if(!is_null($request->upline)){
            $downline = Downline::updateOrCreate(['upline'=>$old_upline,'downline'=>$agent->id],['upline'=>$request->upline]);
        }
        $isComplete = $agent->isNeededToCompleteData();
        if(!$isComplete){
            return redirect()->route('dashboard.index');
        }else{
            return redirect()->route('settings.account.edit')->with('success', 'Data berhasil diperbarui :)');
        }   

    }

}
