<?php

namespace App\Http\Controllers\Admin\Transactions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Transaction\StoreNewTransaction;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\Subdistrict;
use App\Models\Province;
use App\Models\Agent;
use Illuminate\Support\Facades\File;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::latest()->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax() and $request->ajax == 1 and !is_null($request->agent_id)) {
            // $property = DB::select('select id,name as text from properties where agent_id=?', [$request->agent_id]);
            $property = DB::table('properties')
                ->select('id', 'name as text')
                ->where('agent_id', '=', $request->agent_id)
                ->get();
            return response()->json($property);
        }

        $agents = Agent::all();
        return view('admin.transactions.create', compact('agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewTransaction $request)
    {
        $data = [
            'agent_id' => $request->agent_id,
            'property_id' => $request->property_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        $transaction = Transaction::create($data);
        $request->session()->put('inserted_transaction', $transaction);
        return redirect()->route('transactions.index');
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
    public function edit(Request $request, Transaction $transaction)
    {
        if ($request->ajax() and $request->ajax == 1 and !is_null($request->agent_id)) {
            // $property = DB::select('select id,name as text from properties where agent_id=?', [$request->agent_id]);
            $property = DB::table('properties')
                ->select('id', 'name as text')
                ->where('agent_id', '=', $request->agent_id)
                ->get();
            return response()->json($property);
        }

        $agents = Agent::all();
        return view('admin.transactions.edit', compact('transaction', 'agents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNewTransaction $request, Transaction $transaction)
    {
        $data = [
            'agent_id' => $request->agent_id,
            'property_id' => $request->property_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        $transaction->update($data);
        $request->session()->put('inserted_transaction', $transaction);

        return redirect()->route('transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $properties = Transaction::find($id);
        $properties->delete();
        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus');
    }

    public function getDatatablesTransactions()
    {
        $transactions = Transaction::select(
            [
                'transaction.id as id',
                'properties.name as property_name',
                'agents.name as agent_name',
                'transaction.status as status',
                'transaction.keterangan as keterangan'
            ]
        )
            ->join('agents', 'agents.id', '=', 'agent_id')
            ->join('properties', 'properties.id', '=', 'property_id')
            ->orderBy('transaction.created_at', 'desc')
            ->get();
        // dd($transactions);
        return Datatables::of($transactions)
            ->addColumn('status', function ($transaction) {
                if ($transaction->status == 0) {
                    return "<span class=\"badge badge-warning\">In Review</span>";
                } else if ($transaction->status == 1) {
                    return "<span class=\"badge badge-info\">In Progress</span>";
                } else if ($transaction->status == 2) {
                    return "<span class=\"badge badge-success\">Selesai</span>";
                }
            })
            ->addColumn('action', function ($transaction) {
                return "<div class='dropdown'>
                            <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            </button>
                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' href='" . route('transactions.edit', [$transaction->id]) . "'><i class='fa fa-edit'></i>Edit</a>
                                <button class='dropdown-item' onclick=\"deletetransaction(this)\"><i class='fa fa-trash'></i>Delete</button>
                                <form action='" . route('transactions.destroy', [$transaction->id]) . "'' method='POST'>
                                    <input type='hidden' name='_method' value='DELETE'>
                                    <input type='hidden' name='_token' value='" . csrf_token() . "'>
                                </form>
                            </div>
                        </div>";
            })
            ->rawColumns(['status', 'keterangan', 'action'])
            ->make(true);
    }
}
