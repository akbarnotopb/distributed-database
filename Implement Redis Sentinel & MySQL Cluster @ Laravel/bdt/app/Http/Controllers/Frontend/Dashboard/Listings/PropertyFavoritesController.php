<?php

namespace App\Http\Controllers\Frontend\Dashboard\Listings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Property;

class PropertyFavoritesController extends Controller
{
	/*
	*	Menambahkan Property Favorite
	*/

    function add(Request $request)
    {
    	
    	if($request->ajax())
    	{
    		$myProperty = Property::where(['agent_id' => auth()->user()->id, 'id' =>  $request->id,'agent_type'=> 'agent'])->first();
    		if($myProperty)
    		{
    			return response()->json(['status' => 'error', 'messages' => 'Anda tidak bisa menambahkan properti anda sendiri ke dalam daftar favorite','rheader'=>'Gagal!']);	
    		}

            $myProperty = Favorite::where(['agent_id'=>auth()->user()->id,'property_id'=>$request->id])->first();

            if($myProperty){
                return response()->json(['status'=>'info','messages'=>'Properti ini telah ada di daftar favorite anda!','rheader'=>'Peringatan!']);
            }

    		$data = [
    			'property_id' => $request->id,
    			'agent_id' => auth()->user()->id
    		];
    		Favorite::create($data);
    		return response()->json(['status' => 'success', 'messages' => 'properti telah ditambahkan ke daftar properti favorit','rheader'=>'Berhasil!']);
    	}

    	return redirect('errors.403');

    }

}
