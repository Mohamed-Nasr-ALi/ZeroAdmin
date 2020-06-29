<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $successStatus = 200;

    public function getNotification()
    {
        $user = Auth::user();
        $notifications = Notification::Where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $notifications], $this->successStatus);
    }

    public function deleteNotification(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'notification_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }

        $user = Auth::user();
        $notification = Notification::find($request->notification_id);
        if($notification)
            if ($user->id == $notification->user_id) {
                $notification->delete();
                return response()->json(['success' => 'Deleted!'], $this->successStatus);
            }

        return response()->json(['error' => 'Not Allowed', 'code' => 401], 401);
    }
}
