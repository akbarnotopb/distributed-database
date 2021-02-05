<?php

namespace App\Http\Controllers\Frontend\Marketplace;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function index(Request $request){

    	if($request->ajax() and $request->ajax==1){
    		$properties = \App\Models\Property::select('id','name','address','price','description','created_at','built_up','land_size','property_type_id','city_id','sold')->where(['approved'=>1])->orderBy('created_at','desc')->orderBy('created_at','desc')->paginate(10);
    		return response()->json($properties);
    	}

        if(!is_null($request->username)){
            $PropertyTypees = \App\Models\PropertyType::get();
            $Cities = \App\Models\City::get();
            $refered=$request->username;
            return Response()->view('frontend.marketplace.dashboard.index', compact('PropertyTypees', 'Cities','refered'))->withCookie('referal_agent',$request->username,20160); 
        }
	
      	$PropertyTypees = \App\Models\PropertyType::get();
        $Cities = \App\Models\City::get();
        $slider_props = \App\Models\Property::take(5)->get();
        return view('frontend.marketplace.dashboard.index', compact('PropertyTypees', 'Cities','slider_props')); 	
    }
}
