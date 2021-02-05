<?php

namespace App\Http\Controllers\Frontend\Dashboard\Listings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Property\StoreNewProperty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use App\Models\Agent;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\Favorite;
use App\Models\Subdistrict;
use App\Models\Province;
use Intervention\Image\Facades\Image;
class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if($request->ajax() and $request->ajax==1){
        if($request->type=='all'){
          $properties = Property::with('PropertyImages')->paginate(9);
        }else if($request->type=="mine"){
          $properties = Property::with('PropertyImages')->where(['agent_id'=>auth()->user()->id,'agent_type'=>'agent'])->paginate(9);
        }else if($request->type=="sold"){
          $properties = Property::with('PropertyImages')->where(['agent_id'=>auth()->user()->id,'agent_type'=>'agent','sold'=>1])->paginate(9);
        }
        return response()->json($properties);
      }
        // $properties = Property::with('PropertyImages')->get();
        return view('frontend.dashboard.listings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function test(){
      $start = microtime(true);
      $json_string = Redis::connection('sentinel')->lrange('kota14',0,-1);
      $responses = array();
      foreach($json_string as $value){
        array_push($responses,json_decode($value));
      }
      $end = microtime(true);
      var_dump($end-$start);
      return response()->json($responses);
      // $start = microtime(true);
      // $city= City::select('id','name as text')->where('province_id','=',14)->get();
      // $end = microtime(true);
      // var_dump($end-$start);
      // return response()->json($city->toArray());    
    }
    
    
    public function create(Request $request)
    {
      if($request->ajax() and $request->ajax==1 and !is_null($request->city_id)){
        $json_string = Redis::connection('sentinel')->lrange('kecamatan'.$request->city_id,0,-1);
        $responses = array();
        foreach($json_string as $value){
          array_push($responses,json_decode($value));
        }
        return response()->json($responses);
          // $subdistricts = Subdistrict::select('id','name as text')->where('city_id','=',$request->city_id)->get();
          // return  response()->json($subdistricts->toArray());
        }
        else if($request->ajax() and !is_null($request->province_id) and $request->ajax==1){
          $json_string = Redis::connection('sentinel')->lrange('kota'.$request->province_id,0,-1);
          $responses = array();
          foreach($json_string as $value){
            array_push($responses,json_decode($value));
          }
          return response()->json($responses);
          //  $city= City::select('id','name as text')->where('province_id','=',$request->province_id)->get();
          //  return response()->json($city->toArray());         
        }
        else if($request->ajax() and $request->ajax==1){
          $province= Province::select('id','name as text')->get();
          return response()->json($province->toArray());
        }
        $propertyTypees = PropertyType::get();
        $agents=Agent::where('id','!=',auth()->user()->id)->get();
        return view('frontend.dashboard.listings.add', compact('propertyTypees','agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewProperty $request)
    {
      // dd($request);
        $data = [
          'name' => $request->name,
          'price' => $request->price,
          'address' => $request->address,
          'agent_id' => auth()->user()->id,
          'agent_type' => 'agent',
          'listing_type' => $request->listing_type,
          'property_type_id' => $request->property_type,
          'land_size' => $request->land_size,
          'built_up' => $request->built_up,
          'description' => $request->description,
          'area' => $request->area,
          'bedrooms' => $request->bedrooms,
          'bathrooms' => $request->bathrooms,
          'beds' => $request->bed,
          'garages' => $request->garages,
          'city_id' => $request->cities,
          'subdistrict_id' => $request->subdistrict,
          'approved' => 0,
          'sold' => 0,
          'maid_bedrooms' => $request->maid_bedrooms,
          'maid_bathrooms' => $request->maid_bathrooms,
          'certificate' => $request->certificate,
          'year_built' => $request->year_built,
          'electrical_power' => $request->electrical_power,
          'amount_of_down_payment' => str_replace('.','',$request->amount_of_down_payment),
          'estimated_installments' => $request->estimated_installments,
          'complete_address' => $request->complete_address,
          'owner_name' => $request->owner_name,
          'owner_phone' => $request->owner_phone,
          'floor_number' => $request->floor_number,
          'parking_amount' => $request->parking_amount,
          'number_of_floors' => $request->number_of_floors,
          'colisting' => $request->colisting
        ];

        $property = Property::create($data);
        $request->session()->put('inserted_property', $property);
        return redirect()->back()->with('success','Data property berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        $isFavorite = Favorite::where(['property_id' => $property->id, 'agent_id' => auth()->user()->id])->first();
        // dd($agent);
        $colisting = (!is_null($property->colisting))? Agent::find($property->colisting):null;
        return view('frontend.dashboard.listings.show', compact('property','isFavorite','colisting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Property $property)
    {

      if($request->ajax() and $request->ajax==1 and !is_null($request->city_id)){
        $json_string = Redis::connection('sentinel')->lrange('kecamatan'.$request->city_id,0,-1);
        $responses = array();
        foreach($json_string as $value){
          array_push($responses,json_decode($value));
        }
        return response()->json($responses);
          // $subdistricts = Subdistrict::select('id','name as text')->where('city_id','=',$request->city_id)->get();
          // return  response()->json($subdistricts->toArray());
        }
        else if($request->ajax() and !is_null($request->province_id) and $request->ajax==1){
          $json_string = Redis::connection('sentinel')->lrange('kota'.$request->province_id,0,-1);
          $responses = array();
          foreach($json_string as $value){
            array_push($responses,json_decode($value));
          }
          return response()->json($responses);
          //  $city= City::select('id','name as text')->where('province_id','=',$request->province_id)->get();
          //  return response()->json($city->toArray());         
        }
        else if($request->ajax() and $request->ajax==1){
          $province= Province::select('id','name as text')->get();
          return response()->json($province->toArray());
        }

        $request->session()->put('inserted_property', $property);
        $propertyTypees = PropertyType::get();
        $agents=Agent::where('id','!=',auth()->user()->id)->get();
        return view('frontend.dashboard.listings.edit', compact('property', 'propertyTypees','agents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNewProperty $request, Property $property)
    {
        $data = [
          'name' => $request->name,
          'price' => str_replace('.','',$request->price),
          'address' => $request->address,
          'listing_type' => $request->listing_type,
          'property_type_id' => $request->property_type,
          'land_size' => $request->land_size,
          'built_up' => $request->built_up,
          'description' => $request->description,
          'area' => $request->area,
          'bedrooms' => $request->bedrooms,
          'bathrooms' => $request->bathrooms,
          'beds' => $request->bed,
          'garages' => $request->garages,
          'city_id' => $request->cities,
          'subdistrict_id' => $request->subdistrict,
          'approved' => 0,
          'maid_bedrooms' => $request->maid_bedrooms,
          'maid_bathrooms' => $request->maid_bathrooms,
          'certificate' => $request->certificate,
          'year_built' => $request->year_built,
          'electrical_power' => $request->electrical_power,
          'amount_of_down_payment' => str_replace('.','',$request->amount_of_down_payment),
          'estimated_installments' => $request->estimated_installments,
          'complete_address' => $request->complete_address,
          'owner_name' => $request->owner_name,
          'owner_phone' => $request->owner_phone,
          'floor_number' => $request->floor_number,
          'parking_amount' => $request->parking_amount,
          'number_of_floors' => $request->number_of_floors,
          'colisting' => $request->colisting
        ];
        $property->update($data);
        $request->session()->put('inserted_property', $property);
        return redirect()->back()->with('success','Data property berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function removeImageFromDisk($image){
      $path_raw=(public_path().($image->name));
      $path_tumbnail=(public_path().($image->tumbnail));
      if(file_exists($path_raw)){
        unlink($path_raw);
      } 
      if(isset($image->tumbnail) and file_exists($path_tumbnail)){
        unlink($path_tumbnail);
      }
    }

    public function delete(Request $request){
      if($request->ajax()){
        $images = Property::find($request->deleteProp);
        $images = $images->PropertyImages;
        if(count($images)){
          foreach ($images as $image) {
            $this->removeImageFromDisk($image);
            PropertyImage::destroy($image->id);
          }
        }
        Property::destroy($request->deleteProp);
        return response()->json(['success']);
      }
    }

    public function deleteImages(Request $request){
      if($request->ajax()){
        $images = PropertyImage::find($request->deleteImg);
        echo $images;
        $this->removeImageFromDisk($images);
        PropertyImage::destroy($images->id);
        return response()->json(['success']);
      }
    }

    public function storeImages(Request $request)
    {
        if (@$request->hasFile('file')) {
            $image = $request->file('file');
            $imageSize = getimagesize($image);
            $ext= strtolower($image->getClientOriginalExtension());
            if($ext=='jpg' or $ext=='jpeg'){
              $imagesource = imagecreatefromjpeg($image);
            }
            else if ($ext=='png'){
              $imagesource =imagecreatefrompng($image);
            }
            $height = $imageSize[1];
            $width =$imageSize[0];
            $ratio = $imageSize[0]/$imageSize[1]; //width / height
            $targetWidth = 1740;
            $targetHeight = 960;
            $tumbnailbackground = Image::canvas($targetWidth,$targetHeight);
            $realImage = file_get_contents($image->getRealPath());

            if($width>=$height){
              $height=$targetHeight;
              $width=floor($height*$imageSize[0]/$imageSize[1]);
            }
            else{
              $width=$targetWidth;
              $height=floor(($width*$imageSize[1])/$imageSize[0]);
            }

            $cutx = ($width>$targetWidth)? -floor(($width-$targetWidth)/2) : floor(($targetWidth-$width)/2);
            $cuty = ($height>$targetHeight)? -floor(($height-$targetHeight)/2) : floor(($targetHeight-$height)/2);

            $tobeTumbnail=imagecreatetruecolor($width, $height);
            imagecopyresampled($tobeTumbnail, $imagesource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);

            $tumbnailbackground->insert($tobeTumbnail,'top-left',$cutx,$cuty);

            $name = 'property';
            $avatarName = $name.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $path = "/storage/properties/{$avatarName}";
            File::put(public_path().$path, $realImage);
            $avatarName = 'tumbnail-'.$avatarName;
            $path2 = "/storage/properties/{$avatarName}";

            $tumbnailbackground->save(public_path().$path2);

            $data = [
                'name' => $path,
                'property_id' => session()->get('inserted_property')->id,
                'tumbnail' => $path2
            ];
            $property_image = \App\Models\PropertyImage::create($data);
        }
        return response()->json(['success']);
    }
}
