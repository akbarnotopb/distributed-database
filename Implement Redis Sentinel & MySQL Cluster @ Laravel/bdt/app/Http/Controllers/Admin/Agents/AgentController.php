<?php

namespace App\Http\Controllers\Admin\Agents;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Agent\StoreNewAgent;
use Yajra\Datatables\Datatables;
use App\Models\Agent;
use App\Models\Downline;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerifiedNotificationEmailable;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = Agent::latest()->get();
        return view('admin.agents.index',compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Agent $agent)
    {
        $downline = Agent::select('agents.id as id','agents.name as name','agents.phone_number as phone_number' , 'agents.approved as approved', 'agents.email as email','agents.username as username', 'agents.whatsapp as whatsapp')
        ->join('downline','downline.downline','=','agents.id')
        ->where('downline.upline',$agent->id)
        ->get();

        $upline_name = $agent->Uplinenya;
        $_agents=null;
        if($upline_name==null){
            $downid=Downline::select('upline','downline')->where('upline','=',$agent->id)->get(); 
            $downlines=[];
            foreach ($downid as $key => $value) {
                 array_push($downlines,$value->downline);
             } 
            $_agents = Agent::select('id','name')->where('id','!=',$agent->id)->where('approved','=',1)->whereNotIn('id',$downlines)->get();
        }
        
        return view('admin.agents.edit',compact('agent','downline','upline_name','_agents'));
    }


    public function getDatatablesDownline(Request $request){

        $downline=null;
        if($request->id){
        $downline = Agent::select('agents.id as id','agents.name as name','agents.phone_number as phone_number')
        ->join('downline','downline.downline','=','agents.id')
        ->where('downline.upline',$request->id)
        ->get();
        }


        return Datatables::of($downline)
                ->addColumn('id',function($query){
                    return $query->id;
                })
                ->addColumn('name',function($query){
                    return $query->name;
                })
                ->addColumn('phone_number',function($query){
                    return $query->phone_number;
                })
                ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agent $agent)
    {
        // dd($request);
        $request->validate([
            'name'=>'required',
            'email' => [
                'required', 'email', Rule::unique('agents')->ignore($agent->id)
            ],
            'upline' => 'sometimes|required',
            'username' => ['sometimes','required','alpha_num',Rule::unique('agents')->ignore($agent->id)],
            'whatsapp' => 'nullable|numeric|min:8'
        ]);



        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone_number = $request->phone_number;
        if(!is_null($request->username)){
            $agent->username= $request->username;
        }
        if(!is_null($request->upline)){
            // dd($request->upline);
            $downline = Downline::updateOrCreate(['upline'=>$agent->upline,'downline'=>$agent->id],['upline'=>$request->upline]); //Update Or create kalau misal bisa update gausah ganti2
            $agent->upline = $request->upline;
        }
        $agent->address = $request->address;
        $agent->nik = $request->nik;
        $agent->bank_name = $request->bank_name;
        $agent->bank_account = $request->bank_account;
        $agent->bank_customer = $request->bank_customer;
        $agent->whatsapp = $request->whatsapp;
        $agent->save();


        return redirect()->route('agents.index')->with('message','Berhasil mengedit data');
    }

    public function verificate(Request $request){
        $user=Agent::find($request->id);
        $user->approved=$request->stat;
        $user->save();

        if($request->stat==1){
            Mail::to($user->email)->queue(new SendVerifiedNotificationEmailable($user->name));
        }
        return Response()->json(['success']);
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

    public function getDatatablesAgents()
    {
        $agents= Agent::with('downline')->get();
        // dd($downline);
        return Datatables::of($agents)
            ->addColumn('id',function($query){
                return $query->id;
            })
            ->addColumn('email',function($query){
                return $query->email;
            })
            ->addColumn('name',function($query){
                return $query->name;
            })
            ->addColumn('phone_number',function($query){
                return $query->phone_number;
            })
            ->addColumn('approved',function($query){
                return $query->approved == 1 ? "<span class=\"badge badge-success\">Sudah Aktif<span>": "<span class=\"badge badge-danger\">Belum Aktif<span>";
            })
            ->addColumn('upline',function($query){
                // dd($query->upline);
                return (is_null($query->upline))?"<span class=\"badge badge-warning\">Belum Mengisi</span>": (($query->upline==0)?"Admin": (Agent::select('name')->where('id','=',$query->upline)->get()->toArray()[0]['name']));
            })
            ->addColumn('downline',function($downline){
                return ($downline->downline->count()!=0)?$downline->downline->count():"Tidak ada";
            })
            ->addColumn('action', function ($agent) {
                return "<div class='dropdown'>
                            <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' href='".route('agents.edit', [$agent->id])."'><i class='fa fa-edit'></i>Edit</a>
                            </div>
                        </div>";
            })
            ->rawColumns(['downline','action','upline','approved'])
            ->make(true);
    }
}
