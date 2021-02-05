<?php

namespace App\Http\Controllers\Frontend\Marketplace\Listings;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Agent;
class PropertyController extends Controller
{
    //
    public function show(Request $request){
    	$props=Property::find($request->id);
    	if(!is_null($request->username)){
    		$agent = Agent::where(['username'=>$request->username])->first();
            $refered = $request->username;
            $colisting = (isset($props->colisting))?Agent::find($props->colisting):null;
    		return Response()->view('frontend.marketplace.listings.index',compact('props','agent','refered','colisting'))->withCookie('referal_agent',$request->username,20160);
    	}else{
    		if(!is_null($request->cookie('referal_agent'))){
    			$agent=Agent::where(['username'=>$request->cookie('referal_agent')])->first();
    		}else if($props->agent_type!='admin'){
    			$agent=$props->Agent;	
    		}else{
                $agent='admin';
            }
            
            $colisting = (isset($props->colisting))?Agent::find($props->colisting):null;
    		return view('frontend.marketplace.listings.index',compact('props','agent','colisting'));
    	}
    	
    }

    public function search(Request $request){
        // dd($request);

    	if($request->ajax() && $request->ajax==1){
    		$properties = \App\Models\Property::select('id','name','address','price','description','created_at','built_up','land_size','property_type_id','city_id','sold')
            ->where(['approved'=>1])
            ->when($request->type,function($query) use ($request){
                    $query->where('listing_type','=', $request->type);
                })
            ->when($request->category,function($query) use ($request){
                    $query->where('property_type_id','=',$request->category);
                })
            ->when($request->city,function($query) use ($request){
                    $query->where('city_id','=',$request->city);
                })
            ->whereRaw("CAST(price as signed) >= ".$request->minprice)->whereRaw("CAST(price as signed) <= ".$request->maxprice)->orderBy('created_at','desc')->paginate(10);

    		return response()->json($properties);
    	}


  		$PropertyTypees = \App\Models\PropertyType::get();
        $Cities = \App\Models\City::get();
        $SearchParam = (object)$request->all();
        $searchedcity = ($request->city)?\App\Models\City::find($request->city)->name:null;
        $searchedcategory =($request->category)?\App\Models\PropertyType::find($request->category)->name:null;
        $searchedcity = ucwords(strtolower($searchedcity));
        // dd($searchedcity);
        if(!is_null($request->username)){
            $refered=$request->username;
            return response()->view('frontend.marketplace.listings.search', compact('PropertyTypees', 'Cities','SearchParam','searchedcity','searchedcategory','refered'))->withCookie('referal_agent',$request->username,20160);            
        }
        return view('frontend.marketplace.listings.search', compact('PropertyTypees', 'Cities','SearchParam','searchedcity','searchedcategory')); 
    }
}
