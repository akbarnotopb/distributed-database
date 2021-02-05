<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class DashboardController extends Controller
{
    function __construct()
  	{
    	view()->share('navActive', 'dashboard');
  	}

  	public function index(Request $request)
  	{
      if($request->ajax() and $request->ajax==1)
      {

        if(isset($request->city)){
            $Cities = \App\Models\City::select('id','name as text')->get();
            return response()->json($Cities);
        }

        if(isset($request->subdistrict)){
          $json_string = Redis::connection('sentinel')->lrange('kecamatan'.$request->city_id,0,-1);
          $responses = array();
          foreach($json_string as $value){
            array_push($responses,json_decode($value));
          }
          return response()->json($responses);
          // $Subdistricts = \App\Models\Subdistrict::select('id','name as text')->where(['city_id'=>$request->city_id])->get();
          // return response()->json($Subdistricts);
        }

        $properties = \App\Models\Property::with(['Favorite'=>function($query){
          $query->where('agent_id','=',auth()->user()->id);
        }])->select('id','name','address','price','description','built_up','land_size','created_at','listing_type','agent_type','agent_id', 'property_type_id','city_id','sold')->where(['approved' => 1])->orderBy('created_at','desc')->paginate(10);

        return response()->json($properties);
      }


      $PropertyTypees = \App\Models\PropertyType::get();
        return view('frontend.dashboard.dashboard.index', compact('PropertyTypees'));
  	}
}
