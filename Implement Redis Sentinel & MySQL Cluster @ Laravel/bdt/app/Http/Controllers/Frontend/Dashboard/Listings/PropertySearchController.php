<?php

namespace App\Http\Controllers\Frontend\Dashboard\Listings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\Subdistrict;
class PropertySearchController extends Controller
{

    public function index(Request $request)
    {

        // dd($request);

        if($request->ajax() && $request->ajax==1)
        {

            if(isset($request->city) && $request->fetch==1){
                $Cities = \App\Models\City::select('id','name as text')->get();
                return response()->json($Cities);
            }

            if(isset($request->subdistrict) && $request->fetch==1){
              $Subdistricts = \App\Models\Subdistrict::select('id','name as text')->where(['city_id'=>$request->city_id])->get();
              return response()->json($Subdistricts);
            }
            $Properties = \App\Models\Property::with(['Favorite'=>function($query){
                    $query->where('agent_id','=',auth()->user()->id);
            }])
            ->select('id','name','address','price','description','built_up','land_size','created_at','listing_type','agent_type','agent_id', 'property_type_id','city_id','sold')
            ->where(['approved'=>1,'listing_type'=>$request->type])
            ->when($request->category,function($query) use ($request){
                    $query->where('property_type_id','=',$request->category);
                })
            ->when((isset($request->city)),function($query) use ($request){
                    $query->where('city_id','=',$request->city);
                })
            ->when((isset($request->subdistrict)),function($query) use ($request){
                    $query->where('subdistrict_id','=',$request->subdistrict);
                })
            ->whereRaw("CAST(price as signed) >= ".$request->minprice)
            ->whereRaw("CAST(price as signed) <= ".$request->maxprice)->orderby('created_at','desc')->paginate(10);

            return response()->json($Properties);
        }

    	$PropertyTypees = \App\Models\PropertyType::get();
        $SearchParam = (object)$request->all();
        $searchedcategory = isset($request->category)? PropertyType::find($request->category)->name:null;

        $searchedcity = isset($request->city)? ucwords(strtolower(City::find($request->city)->name)):null;

        $searchedsub = isset($request->subdistrict)? ucwords(strtolower(Subdistrict::find($request->subdistrict)->name)):null;

        return view('frontend.dashboard.listings.search', compact('PropertyTypees', 'SearchParam','searchedcategory','searchedsub','searchedcity'));
    }

}
