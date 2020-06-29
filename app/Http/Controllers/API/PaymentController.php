<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    protected $successStatus = 200;

    public function makePayment(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'title' => 'required|string',
                'amount' => 'required',
                'pin' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user = Auth::user();

        if ($user->pin == $request->pin) {

            $walllet = $user->wallet;
            if ($walllet->current_balance >= $request->amount) {

                $walllet->current_balance = $walllet->current_balance - $request->amount;
                $walllet->total_spint = $walllet->total_spint + $request->amount;
                $walllet->save();

                $transaction = new Transaction([
                    'user_id' => $user->id,
                    'title' => 'Pay money',
                    'type' => '-1',
                    'amount' => $request->amount
                ]);

                $transaction->save();

                return response()->json(['success' => $transaction], $this->successStatus);
            } else
                return response()->json(['error' => 'you have not enough money!', 'code' => 400], 400);
        } else
            return response()->json(['error' => 'Wrong pin!', 'code' => 400], 400);
    }
}
