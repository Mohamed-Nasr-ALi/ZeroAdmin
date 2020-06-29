<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Transaction;
use App\User;
use App\Paycode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaycodeController extends Controller
{
    protected $successStatus = 200;

    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->role == 1) {
            $validator = validator()->make(
                $request->all(),
                [
                    'amount' => 'required',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
            }

            $paycodeValue = random_int(10000000000, 99999999999);
            $paycode = new Paycode([
                'user_id' => $user->id,
                'paycode' => $paycodeValue,
                'amount' => $request->amount
            ]);
            $paycode->save();

            return response()->json(['success' => $paycode], $this->successStatus);
        } else {
            return response()->json(['error' => "Invalied Permission!", 'code' => 401], 401);
        }
    }

    public function getPaycodeState(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'paycode' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }

        $paycode = Paycode::where('paycode', $request->paycode)->first();
        if ($paycode)
            return response()->json(['used' => $paycode->used], $this->successStatus);
        return response()->json(['error' => "Invalied Paycode!", 'code' => 401], 401);
    }

    public function usePaycode(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'paycode' => 'required',
                'amount' => 'required',
                'pin' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $paycode = Paycode::where('paycode', $request->paycode)->first();
        if (!$paycode || $paycode->used == 1)
            return response()->json(['error' => "Invalied Paycode!", 'code' => 401], 401);

        $user = Auth::user();
        if ($user->pin == $request->pin) {
            if ($paycode->amount == $request->amount && $request->amount > 0) {

                $user_to_pay = $paycode->user;
                $user_to_pay_wallet = $user_to_pay->wallet;
                if ($user_to_pay_wallet->current_balance >= $request->amount) {
                    $user_to_pay_wallet->current_balance = $user_to_pay_wallet->current_balance - $request->amount;
                    $user_to_pay_wallet->total_spint = $user_to_pay_wallet->total_spint + $request->amount;
                    $user_to_pay_wallet->save();

                    $wallet = $user->wallet;
                    $wallet->current_balance = $wallet->current_balance + $request->amount;
                    if ($request->amount < 0) {
                        $wallet->total_spint = $wallet->total_spint + $request->amount;
                    }
                    $wallet->save();

                    $paycode->used = 1;
                    $paycode->save();

                    $transaction1 = new Transaction([
                        'user_id' => $paycode->user_id,
                        'title' => 'Send money',
                        'type' => '-1',
                        'amount' => $request->amount,
                        'first_user_name' => $paycode->user->full_name,
                        'second_user_name' => $user->full_name,
                        'cc' => '0'
                    ]);

                    $transaction2 = new Transaction([
                        'user_id' => $user->id,
                        'title' => 'Received money',
                        'type' => '+1',
                        'amount' => $request->amount,
                        'first_user_name' => $user->full_name,
                        'second_user_name' => $paycode->user->full_name,
                        'cc' => '0'
                    ]);

                    $transaction1->save();
                    $transaction2->save();

                    $notification1 = new Notification([
                        'user_id' => $paycode->user_id,
                        'title' => 'You Send Money!',
                        'body' => 'You send,' . $request->amount . ', to ,' . $user->full_name,
                        'type' => '2'
                    ]);

                    $notification2 = new Notification([
                        'user_id' => $user->id,
                        'title' => 'You Received Money!',
                        'body' => 'You get,' . $request->amount . ', from ,' . $paycode->user->full_name,
                        'type' => '3'
                    ]);

                    $notification1->save();
                    $notification2->save();

                    $this->sendNotification($notification1->title, $notification1->body, $paycode->user, $notification1->type);
                    $this->sendNotification($notification2->title, $notification2->body, $user, $notification2->type);

                    return response()->json(['success' => $notification2], $this->successStatus);
                } else {
                    return response()->json(['error' => 'not have money!', 'code' => 401], 401);
                }
            } else {
                return response()->json(['error' => 'Wrong Amount!', 'code' => 401], 401);
            }
        } else {
            return response()->json(['error' => 'Wrong Pin!', 'code' => 401], 401);
        }
    }

    public function pay(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'phone_number' => 'required',
                'amount' => 'required',
                'pin' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user = Auth::user();
        if ($user->phone == $request->phone_number)
            return response()->json(['error' => 'Invalied phone!', 'code' => 401], 401);

        $user_to_pay = User::where('phone', $request->phone_number)->first();

        if ($user_to_pay) {
            if ($user->pin == $request->pin) {
                $wallet = $user->wallet;
                if ($request->amount > 0) {
                    if ($wallet->current_balance >= $request->amount) {
                        $wallet->current_balance = $wallet->current_balance - $request->amount;
                        $wallet->total_spint = $wallet->total_spint + $request->amount;
                        $wallet->save();

                        $user_to_pay_wallet = $user_to_pay->wallet;
                        $user_to_pay_wallet->current_balance = $user_to_pay_wallet->current_balance + $request->amount;
                        $user_to_pay_wallet->save();

                        if ($user->app == "1" && $user_to_pay->app == "1") {
                            $transaction1 = new Transaction([
                                'user_id' => $user->id,
                                'title' => 'Send money',
                                'type' => '-1',
                                'amount' => $request->amount,
                                'first_user_name' => $user->full_name,
                                'second_user_name' => $user_to_pay->full_name,
                                'cc' => '1'
                            ]);

                            $transaction2 = new Transaction([
                                'user_id' => $user_to_pay->id,
                                'title' => 'Received money',
                                'type' => '+1',
                                'amount' => $request->amount,
                                'first_user_name' => $user_to_pay->full_name,
                                'second_user_name' => $user->full_name,
                                'cc' => '1'
                            ]);

                            $transaction1->save();
                            $transaction2->save();
                        } else {
                            $transaction1 = new Transaction([
                                'user_id' => $user->id,
                                'title' => 'Send money',
                                'type' => '-1',
                                'amount' => $request->amount,
                                'first_user_name' => $user->full_name,
                                'second_user_name' => $user_to_pay->full_name,
                                'cc' => '0'
                            ]);

                            $transaction2 = new Transaction([
                                'user_id' => $user_to_pay->id,
                                'title' => 'Received money',
                                'type' => '+1',
                                'amount' => $request->amount,
                                'first_user_name' => $user_to_pay->full_name,
                                'second_user_name' => $user->full_name,
                                'cc' => '0'
                            ]);

                            $transaction1->save();
                            $transaction2->save();
                        }


                        $notification1 = new Notification([
                            'user_id' => $user->id,
                            'title' => 'You Send Money!',
                            'body' => 'You send ,' . $request->amount . ', to ,' . $user_to_pay->full_name,
                            'type' => '2'
                        ]);

                        $notification2 = new Notification([
                            'user_id' => $user_to_pay->id,
                            'title' => 'You Received Money!',
                            'body' => 'You get ,' . $request->amount . ', from ,' . $user->full_name,
                            'type' => '3'
                        ]);

                        $notification1->save();
                        $notification2->save();

                        $this->sendNotification($notification1->title, $notification1->body, $user, $notification1->type);
                        $this->sendNotification($notification2->title, $notification2->body, $user_to_pay, $notification2->type);

                        return response()->json(['success' => $notification1], $this->successStatus);
                    } else {
                        return response()->json(['error' => 'not have money!', 'code' => 401], 401);
                    }
                } else {
                    return response()->json(['error' => 'Wrong amount!', 'code' => 401], 401);
                }
            } else {
                return response()->json(['error' => 'Wrong Pin!', 'code' => 401], 401);
            }
        } else {
            return response()->json(['error' => 'Wrong phone number!', 'code' => 401], 401);
        }
    }
}
