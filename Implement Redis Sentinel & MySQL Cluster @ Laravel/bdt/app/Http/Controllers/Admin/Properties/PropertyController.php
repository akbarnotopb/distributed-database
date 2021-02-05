<?php

namespace App\Http\Controllers\Admin\Properties;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Property\StoreNewProperty;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\Subdistrict;
use App\Models\Province;
use App\Models\Agent;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::latest()->get();
        
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->ajax() and $request->ajax==1 and !is_null($request->city_id)){
          $subdistricts = Subdistrict::select('id','name as text')->where('city_id','=',$request->city_id)->get();
          return  response()->json($subdistricts->toArray());
        }
        else if($request->ajax() and !is_null($request->province_id) and $request->ajax==1){
           $city= City::select('id','name as text')->where('province_id','=',$request->province_id)->get();
           return response()->json($city->toArray());         
        }
        else if($request->ajax() and $request->ajax==1){
          $province= Province::select('id','name as text')->get();
          return response()->json($province->toArray());
        }

        $property_typees = PropertyType::get();
        $cities = City::get();
        $agents= Agent::all();
        return view('admin.properties.create', compact('property_typees','cities','agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewProperty $request)
    {
        $data = [
          'name' => $request->name,
          'price' => $request->price,
          'address' => $request->address,
          'agent_id' => 0,
          'agent_type' => 'admin',
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
          'approved' => 1,
          'sold'=>0,
          'maid_bedrooms' => $request->maid_bedrooms,
          'maid_bathrooms' => $request->maid_bathrooms,
          'certificate' => $request->certificate,
          'year_built' => $request->year_built,
          'electrical_power' => $request->electrical_power,
          'amount_of_down_payment' => $request->amount_of_down_payment,
          'estimated_installments' => $request->estimated_installments,
          'complete_address' => $request->complete_address,
          'owner_name' => $request->owner_name,
          'owner_phone' => $request->owner_phone,
          'floor_number' => $request->floor_number,
          'number_of_floors' => $request->number_of_floors,
          'parking_amount' => $request->parking_amount,
          'colisting' => $request->colisting
        ];

        $property = Property::create($data);
        $request->session()->put('inserted_property', $property);
        return redirect()->route('emails.send.newprops.notification',['propsid'=>$property->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Property $property)
    {
      // dd($Property->City->Province->id);
        if($request->ajax() and $request->ajax==1 and !is_null($request->city_id)){
          $subdistricts = Subdistrict::select('id','name as text')->where('city_id','=',$request->city_id)->get();
          return  response()->json($subdistricts->toArray());
        }
        else if($request->ajax() and !is_null($request->province_id) and $request->ajax==1){
           $city= City::select('id','name as text')->where('province_id','=',$request->province_id)->get();
           return response()->json($city->toArray());         
        }
        else if($request->ajax() and $request->ajax==1){
          $province= Province::select('id','name as text')->get();
          return response()->json($province->toArray());
        }
        
        $request->session()->put('inserted_property', $property);
        $property_typees = PropertyType::get();
        $agents= ($property->agent_type!='admin')?Agent::where('id','!=',$property->agent_id)->get() : Agent::all();
        return view('admin.properties.edit', compact('property', 'property_typees','agents'));
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
      $sold_stats = ($request->approved==2)?1:0;
      $approved_stats = ($request->approved==2)?1:$request->approved;
      $approved_old_stats = $property->approved;
        $data = [
          'name' => $request->name,
          'price' => $request->price,
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
          'approved' => $approved_stats,
          'sold' => $sold_stats,
          'maid_bedrooms' => $request->maid_bedrooms,
          'maid_bathrooms' => $request->maid_bathrooms,
          'certificate' => $request->certificate,
          'year_built' => $request->year_built,
          'electrical_power' => $request->electrical_power,
          'amount_of_down_payment' => $request->amount_of_down_payment,
          'estimated_installments' => $request->estimated_installments,
          'complete_address' => $request->complete_address,
          'owner_name' => $request->owner_name,
          'owner_phone' => $request->owner_phone,
          'floor_number' => $request->floor_number,
          'number_of_floors' => $request->number_of_floors,
          'parking_amount' => $request->parking_amount,
          'colisting' => $request->colisting
        ];

        $property->update($data);
        $request->session()->put('inserted_property', $property);
        if($approved_old_stats==0 and $approved_stats==1){
          return redirect()->route('emails.send.newprops.notification',['propsid'=>$property->id]);
        }

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
        $properties = Property::with('PropertyImages')->find($id);
        foreach ($properties->PropertyImages as $image) {
            File::delete(public_path().$image->name);
            if(isset($image->tumbnail)){
              File::delete(public_path().$image->tumbnail);
            }
            $image->delete();
        }
        $properties->delete();
        return redirect()->back()->with('success','Data property berhasil dihapus');
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

    public function getDatatablesProperties()
    {
        $properties = Property::select(['properties.id as id','properties.name as name','properties.price as price','properties.address as address', 'properties.listing_type as listing_type', 'properties.agent_type as agent_type', 'properties.agent_id as agent_id', 'properties.approved as approved','properties.sold as sold','properties.created_at','property_type_id','properties.city_id as city_id'])->orderBy('properties.created_at','desc')->get();
        // dd($properties
        return Datatables::of($properties)
            ->addColumn('status', function ($property) {
              if($property->approved==0){
                return "<span class=\"badge badge-warning\">Pending</span>";
              }
              else if($property->approved && $property->sold==0){
                return "<span class=\"badge badge-success\">Aktif</span>";  
              }
              else if($property->sold){
                return "<span class=\"badge badge-info\">Terjual</span>";
              }
            })
            ->addColumn('owner_name', function ($owner) {
                if($owner->agent_type == 'agent'){
                    return \App\Models\Agent::where('id',$owner->agent_id)->first()->name;
                }
                else{
                    return "Admin";
                }
            })
            ->addColumn('action', function ($property) {
                return "<div class='dropdown'>
                            <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' href='".route('properties.edit', [$property->id])."'><i class='fa fa-edit'></i>Edit</a>
                                <button class='dropdown-item' onclick=\"deleteproperty(this)\"><i class='fa fa-trash'></i>Delete</button>
                                <form action='".route('properties.destroy', [$property->id])."'' method='POST'>
                                    <input type='hidden' name='_method' value='DELETE'>
                                    <input type='hidden' name='_token' value='".csrf_token()."'>
                                </form>
                            </div>
                        </div>";
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    function deleteImages(Request $request)
    {
        $property_image = \App\Models\PropertyImage::find($request->id);
        File::delete(public_path().$property_image->name);
        if(isset($property_image->tumbnail)){
          File::delete(public_path().$property_image->tumbnail);
        }
        // return $image->tumbnail;
        $property_image->delete();
        return redirect()->back()->with('success','Data images berhasil disimpan');
    }


}
