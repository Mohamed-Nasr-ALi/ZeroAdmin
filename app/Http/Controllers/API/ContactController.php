<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ContactController extends Controller
{
    protected $successStatus = 200;

    public function checkContact(Request $request)
    {
        $validator = validator()->make(
            $request->all(),
            [
                'contacts' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }

        $contacts = [];

        foreach ($request->contacts as $key => $contact) {
            $user = User::where('phone', $contact)->first();
            if ($user)
                array_push($contacts, $user->phone);
        }

        return response()->json(['success' => $contacts], $this->successStatus);
    }
}
