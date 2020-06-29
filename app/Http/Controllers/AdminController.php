<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Transaction;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors(), 'code' => 401], 401);
        }

        $email = $request['email'];
        $input_password = $request['password'];
        $user = User::where('email', $email)->first();
        if ($user && $user->role == 0) {
            if ($this->check_password($input_password, $user->password, $user->salt)) {
                $user->AauthAcessToken()->delete();
                $tokenResult = $user->createToken('MyApp');
                $token = $tokenResult->token;
                $token->save();

                $success['token'] = $tokenResult->accessToken;
                $user->save();

                return response()->json(['success' => $success, 'code' => $this->successStatus], $this->successStatus);
            } else {
                return response()->json(['error' => 'wrong phone or password', 'code' => 401], 401);
            }
        } else {
            return response()->json(['error' => 'wrong phone or password', 'code' => 401], 401);
        }
    }

    public function details()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        return response()->json(['success' => $user, 'code' => $this->successStatus], $this->successStatus);
    }

    protected function genrate_salt($len = 32)
    {
        return substr(md5(uniqid(rand(), true)), 0, $len);
    }

    protected function hash_new_password($password, $salt)
    {
        if (empty($password) && empty($salt)) {
            return FALSE;
        }
        return sha1($password . $salt);
    }

    protected function check_password($input_password, $password, $salt)
    {
        $real_password = $this->hash_new_password($input_password, $salt);
        if ($password == $real_password) {
            return True;
        }
        return False;
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $client = $user;
        if ($user->role == 1) {

            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
            }

            $client->full_name = $request->full_name;

            if ($client->email != $request->email) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|unique:users'
                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
                }

                $client->email = $request->email;
            }

            if ($client->phone != $request->phone) {
                $validator = Validator::make($request->all(), [
                    'phone' => 'required|string|unique:users'
                ]);

                if ($validator->fails()) {
                    return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
                }

                $client->phone = $request->phone;
            }

            $client->save();
            return response()->json(['success' => $client, 'code' => 200], 200);
        } else {
            return response()->json(['error' => 'not allowed', 'code' => 401], 401);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }
        $user = Auth::user();
        if ($this->check_password($request->old_password, $user->password, $user->salt)) {
            $salt = $this->genrate_salt();
            $password = $this->hash_new_password($request->new_password, $salt);

            $user->password = $password;
            $user->salt = $salt;
            $user->save();
            return response()->json(['success' => 'Changed', 'code' => $this->successStatus], $this->successStatus);
        } else {
            return response()->json(['error' => 'wrong password', 'code' => 401], 401);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->AauthAcessToken()->delete();
            return response()->json(['success' => 'done!', 'code' => $this->successStatus], $this->successStatus);
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

        if ($user->pin == $request->pin) {
            $wallet = $user->wallet;
            if ($wallet->current_balance >= $request->amount) {
                $wallet->current_balance = $wallet->current_balance - $request->amount;
                $wallet->total_spint = $wallet->total_spint + $request->amount;
                $wallet->save();

                $user_to_pay_wallet = $user_to_pay->wallet;
                $user_to_pay_wallet->current_balance = $user_to_pay_wallet->current_balance + $request->amount;
                $user_to_pay_wallet->save();

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
            return response()->json(['error' => 'Wrong Pin!', 'code' => 401], 401);
        }
    }

    public function myTransactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $transactions, 'code' => $this->successStatus], $this->successStatus);
    }

    public function ccTransactions()
    {
        $transactions = Transaction::where('cc', 1)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $transactions, 'code' => $this->successStatus], $this->successStatus);
    }

    public function cmTransactions()
    {
        $transactions = Transaction::where('cc', 0)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $transactions, 'code' => $this->successStatus], $this->successStatus);
    }
}
