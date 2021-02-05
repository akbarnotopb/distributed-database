<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Property;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $agent = Agent::select('id')->get();
        $properties = Property::select('id')->get();
        $transaction = Transaction::select('id')->get();
        return view('admin.index')
            ->with([
                'total_agents' => $agent->count(),
                'total_properties' => $properties->count(),
                'total_transactions' => $transaction->count()
            ]);
    }
}
