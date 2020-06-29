<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Request as AppRequest;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    protected $successStatus = 200;

    public function create(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'title' => 'required|string',
                'description' => 'required|max:1000',
                'amount' => 'required',
                'phone_number' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user = Auth::user();
        if ($user->phone == $request->phone_number)
            return response()->json(['error' => 'Invalied phone!', 'code' => 401], 401);

        $user_to_send = User::where('phone', $request->phone_number)->first();
        if ($user_to_send) {
            $appRequest = new AppRequest([
                'user_id' => $user->id,
                'state' => '0',
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'phone_number' => $request->phone_number
            ]);
            $appRequest->save();

            $notification = new Notification([
                'user_id' => $user_to_send->id,
                'title' => 'New Request!',
                'body' => 'You have a request from ,' . $user->full_name,
                'type' => '1'
            ]);
            $notification->save();
            $this->sendNotification($notification->title, $notification->body, $user_to_send, $notification->type);
            return response()->json(['success' => $appRequest], $this->successStatus);
        } else {
            return response()->json(['error' => "invalied phone number!", 'code' => 401], 401);
        }
    }

    public function inRequests()
    {
        $user = Auth::user();
        $requests = AppRequest::Where('phone_number', $user->phone)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $requests], $this->successStatus);
    }

    public function outRequests()
    {
        $user = Auth::user();
        $requests = AppRequest::Where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $requests], $this->successStatus);
    }

    public function accept(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'request_id' => 'required',
                'pin' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user_request = AppRequest::find($request->request_id);
        $user = Auth::user();

        if ($user_request)
            if ($user->phone == $user_request->phone_number)
                if ($user->pin == $request->pin)
                    if ($user_request->state == 0) {

                        $wallet = $user->wallet;
                        if ($request->amount > 0) {
                            if ($wallet->current_balance >= $user_request->amount) {
                                $user_request->state = 1;
                                $user_request->save();

                                $wallet->current_balance = $wallet->current_balance - $user_request->amount;
                                $wallet->total_spint = $wallet->total_spint + $user_request->amount;
                                $wallet->save();

                                $request_user = $user_request->user;
                                $request_user_wallet = $request_user->wallet;
                                $request_user_wallet->current_balance = $request_user_wallet->current_balance + $user_request->amount;
                                $request_user_wallet->save();
                                if ($request_user->app == "1" && $user->app == "1") {
                                    $transaction1 = new Transaction([
                                        'user_id' => $user->id,
                                        'title' => 'Send money',
                                        'type' => '-1',
                                        'amount' => $user_request->amount,
                                        'first_user_name' => $user->full_name,
                                        'second_user_name' => $request_user->full_name,
                                        'cc' => '1'
                                    ]);

                                    $transaction2 = new Transaction([
                                        'user_id' => $request_user->id,
                                        'title' => 'Received money',
                                        'type' => '+1',
                                        'amount' => $user_request->amount,
                                        'first_user_name' => $request_user->full_name,
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
                                        'amount' => $user_request->amount,
                                        'first_user_name' => $user->full_name,
                                        'second_user_name' => $request_user->full_name,
                                        'cc' => '0'
                                    ]);

                                    $transaction2 = new Transaction([
                                        'user_id' => $request_user->id,
                                        'title' => 'Received money',
                                        'type' => '+1',
                                        'amount' => $user_request->amount,
                                        'first_user_name' => $request_user->full_name,
                                        'second_user_name' => $user->full_name,
                                        'cc' => '0'
                                    ]);
                                    $transaction1->save();
                                    $transaction2->save();
                                }


                                $notification1 = new Notification([
                                    'user_id' => $user->id,
                                    'title' => 'You Send Money!',
                                    'body' => 'You send ,' . $user_request->amount . ', to ,' . $request_user->full_name,
                                    'type' => '2'
                                ]);

                                $notification2 = new Notification([
                                    'user_id' => $request_user->id,
                                    'title' => 'You Received Money!',
                                    'body' => 'You get ,' . $user_request->amount . ', from ,' . $user->full_name,
                                    'type' => '3'
                                ]);

                                $notification1->save();
                                $notification2->save();

                                $this->sendNotification($notification1->title, $notification1->body, $user, $notification1->type);
                                $this->sendNotification($notification2->title, $notification2->body, $request_user, $notification2->type);

                                return response()->json(['success' => $transaction1], $this->successStatus);
                            } else
                                return response()->json(['error' => 'you have not enough money!', 'code' => 400], 400);
                        } else
                            return response()->json(['error' => 'Wrong amount!', 'code' => 401], 401);
                    } else
                        return response()->json(['error' => 'Wrong Request!', 'code' => 400], 400);
                else
                    return response()->json(['error' => 'Wrong pin!', 'code' => 400], 400);
            else
                return response()->json(['error' => 'Wrong Account Number!', 'code' => 400], 400);
        else
            return response()->json(['error' => 'Wrong request id!', 'code' => 400], 400);
    }

    public function denay(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'request_id' => 'required',
                'pin' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user_request = AppRequest::find($request->request_id);
        $user = Auth::user();
        if ($user_request)
            if ($user->phone == $user_request->phone_number)
                if ($user->pin == $request->pin)
                    if ($user_request->state == 0) {
                        $user_request->state = -1;
                        $user_request->save();

                        $request_user = $user_request->user;
                        $notification = new Notification([
                            'user_id' => $request_user->id,
                            'title' => 'denayed!',
                            'body' => 'Your request denayed',
                            'type' => '4'
                        ]);
                        $notification->save();

                        $this->sendNotification($notification->title, $notification->body, $request_user, $notification->type);

                        return response()->json(['success' => "Denayed!"], $this->successStatus);
                    } else
                        return response()->json(['error' => 'Wrong Request!', 'code' => 400], 400);
                else
                    return response()->json(['error' => 'Wrong pin!', 'code' => 400], 400);
            else
                return response()->json(['error' => 'Wrong Account Number!', 'code' => 400], 400);
        else
            return response()->json(['error' => 'Wrong request id!', 'code' => 400], 400);
    }

    public function getRequest($id)
    {
        $user = Auth::user();
        $request = AppRequest::find($id);
        if ($user->id == $request->user_id)
            return response()->json(['success' => $request], $this->successStatus);
        return response()->json(['error' => 'Not allowed!', 'code' => 400], 400);
    }
}
