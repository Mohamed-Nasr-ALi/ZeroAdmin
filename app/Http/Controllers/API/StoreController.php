<?php

namespace App\Http\Controllers\API;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Type;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $successStatus = 200;

    public function getCategorys()
    {
        $types = Type::where('state', 1)->get();
        return response()->json(['success' => $types], $this->successStatus);
    }

    public function getStores($type_id)
    {
        $agents = Agent::where('type_id', $type_id)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $agents], $this->successStatus);
    }

    public function transactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())->where('cc', 0)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $transactions, 'code' => $this->successStatus], $this->successStatus);
    }
}
