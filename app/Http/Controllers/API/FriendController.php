<?php

namespace App\Http\Controllers\API;

use App\Friend;
use App\Friend_request;
use App\Http\Controllers\Controller;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    protected $successStatus = 200;

    public function sendFiendRequest(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'full_name' => 'required|string',
                'phone_number' => 'required|string'
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
            $friend_requests = Friend_request::where('user_id', $user->id)->where('phone_number', $request->phone_number)->first();
            if (!$friend_requests) {
                $friend_request = new Friend_request([
                    'user_id' => $user->id,
                    'phone_number' => $request->phone_number,
                    'full_name' => $request->full_name
                ]);
                $friend_request->save();
                $notification = new Notification([
                    'user_id' => $user_to_send->id,
                    'title' => 'New friend!',
                    'body' => 'You have a new friend request from ,' . $user->full_name,
                    'type' => '5',
                    'friend_request_id' => $friend_request->id
                ]);
                $notification->save();

                $this->sendNotification($notification->title, $notification->body, $user_to_send, $notification->type);

                return response()->json(['success' => $friend_request], $this->successStatus);
            }
            return response()->json(['error' => 'already sent a friend request', 'code' => 401], 401);
        }
        return response()->json(['error' => 'Wrong Phone number', 'code' => 401], 401);
    }

    public function getInFriendRequests()
    {
        $user = Auth::user();
        $friend_requests = Friend_request::where('phone_number', $user->phone)->get();
        return response()->json(['success' => $friend_requests], $this->successStatus);
    }

    public function getOutFriendRequests()
    {
        $user = Auth::user();
        $friend_requests = $user->friend_requests;
        return response()->json(['success' => $friend_requests], $this->successStatus);
    }

    public function getFriends()
    {
        $user = Auth::user();
        $friends = $user->friends;
        return response()->json(['success' => $friends], $this->successStatus);
    }

    public function acceptFriendRequest(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'friend_request_id' => 'required',
                'notification_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user = Auth::user();

        $friend_request = Friend_request::find($request->friend_request_id);
        if ($friend_request && $friend_request->phone_number == $user->phone) {
            $sender = $friend_request->user;

            $friend_request->state = 1;
            $friend_request->save();
            $friend1 = new Friend([
                'user_id' => $user->id,
                'phone_number' => $sender->phone,
                'full_name' => $sender->full_name
            ]);

            $friend2 = new Friend([
                'user_id' => $sender->id,
                'phone_number' => $user->phone,
                'full_name' => $friend_request->full_name
            ]);

            $friend1->save();
            $friend2->save();
            $friend_request->delete();
            $notification = Notification::find($request->notification_id);
            if ($notification->type == 5) {
                $notification->delete();
            }
            return response()->json(['success' => True], $this->successStatus);
        }
        return response()->json(['error' => 'Wrong friend request', 'code' => 401], 401);
    }

    public function denayFriendRequest(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'friend_request_id' => 'required',
                'notification_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $user = Auth::user();

        $friend_request = Friend_request::find($request->friend_request_id);
        if ($friend_request && $friend_request->phone_number == $user->phone) {
            $friend_request->state = -1;
            $friend_request->save();
            $friend_request->delete();
            $notification = Notification::find($request->notification_id);
            if ($notification->type == 5) {
                $notification->delete();
            }
            return response()->json(['success' => True], $this->successStatus);
        }
        return response()->json(['error' => 'Wrong friend request', 'code' => 401], 401);
    }

    public function delete(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'phone_number' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }

        $user = Auth::user();
        if ($user->phone == $request->phone_number)
            return response()->json(['error' => 'Invalied phone!', 'code' => 401], 401);

        $friend = Friend::where('user_id', $user->id)->where('phone_number', $request->phone_number)->first();
        if ($friend) {
            $friend->delete();
            $user_friend = User::where('phone', $request->phone_number)->first();
            $friend = Friend::where('user_id', $user_friend->id)->where('phone_number', $user->phone)->first();
            $friend->delete();
        }

        return response()->json(['success' => True], $this->successStatus);
    }
}
