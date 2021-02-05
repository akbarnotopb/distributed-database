<?php

namespace App\Http\Controllers\Frontend\Dashboard\Transactions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Transaction\StoreNewTransaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\Agent;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\City;
use App\Models\Favorite;
use App\Models\Subdistrict;
use App\Models\Province;
use App\Models\Transaction;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;



class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::latest()->where((['agent_id' => auth()->user()->id]))->get();
        return view('frontend.dashboard.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $properties = DB::table('properties')
            ->select('properties.id', 'properties.name')
            ->where(([
                'properties.agent_id' =>  auth()->user()->id,
            ]))
            ->get();
        return view('frontend.dashboard.transactions.add', compact('properties'));
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
            'agent_id' => auth()->user()->id,
            'property_id' => $request->property_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        $transaction = Transaction::create($data);
        $request->session()->put('inserted_transaction', $transaction);
        return redirect()->route('transaction.agent.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
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
        $properties = DB::table('properties')
            ->select('properties.id', 'properties.name')
            ->join('transaction', 'properties.id', '<>', 'transaction.property_id')
            ->where(([
                'properties.agent_id' =>  auth()->user()->id,
                'transaction.agent_id' =>  auth()->user()->id,
            ]))
            ->get();
        return view('frontend.dashboard.transactions.edit', compact('properties', 'transaction'));
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
            'agent_id' => auth()->user()->id,
            'property_id' => $request->property_id,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        $transaction->update($data);
        $request->session()->put('inserted_transaction', $transaction);

        return redirect()->route('transaction.agent.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transactions = Transaction::find($id);
        $transactions->delete();
        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus');
    }

    public function getDatatablesTransactions()
    {
        $transactions = Transaction::select(
            [
                // 'transaction.id as id',
                'properties.name as property_name',
                'transaction.status as status',
                'transaction.keterangan as keterangan'
            ]
        )
            ->join('agents', 'agents.id', '=', 'agent_id')
            ->join('properties', 'properties.id', '=', 'property_id')
            ->where((['transaction.agent_id' => auth()->user()->id]))
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
                            <a class='btn btn-warning' href='" . route('transaction.agent.edit', [$transaction->id]) . "'><i class='fa fa-edit'></i>Edit</a>
                            <a class='btn btn-danger' onclick=\"deletetransaction(this)\"><i class='fa fa-trash'></i>Delete</a>
                            <form action='" . route('transaction.agent.destroy', [$transaction->id]) . "'' method='POST'>
                                <input type='hidden' name='_method' value='DELETE'>
                                <input type='hidden' name='_token' value='" . csrf_token() . "'>
                            </form>
                        </div>";
            })
            ->rawColumns(['status', 'keterangan', 'action'])
            ->make(true);
    }
}
