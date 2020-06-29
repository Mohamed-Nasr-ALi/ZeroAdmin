<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\Http\Controllers\Controller;
use App\Request as AppRequest;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Validator;

class ClientController extends Controller
{

    public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|string|min:8',
            'device_id' => 'required|string',
            'app' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors(), 'code' => 401], 401);
        }

        $phone = $request['phone'];
        $input_password = $request['password'];
        $user = User::where('phone', $phone)->first();
        if ($user) {
            if ($this->check_password($input_password, $user->password, $user->salt)) {
                $user->AauthAcessToken()->delete();
                $tokenResult = $user->createToken('MyApp');
                $token = $tokenResult->token;
                $token->save();

                $success['token'] = $tokenResult->accessToken;
                $user->device_id = $request->device_id;
                $user->app = $request->app;
                $user->save();

                return response()->json(['success' => $success, 'code' => $this->successStatus], $this->successStatus);
            } else {
                return response()->json(['error' => 'wrong phone or password', 'code' => 401], 401);
            }
        } else {
            return response()->json(['error' => 'wrong phone or password', 'code' => 401], 401);
        }
    }


    public function loginVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|string|min:8',
            'device_id' => 'required|string',
            'app' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors(), 'code' => 401], 401);
        }

        $phone = $request['phone'];
        $input_password = $request['password'];
        $user = User::where('phone', $phone)->first();
        if ($user && $user->role == 1) {
            if ($this->check_password($input_password, $user->password, $user->salt)) {
                $user->AauthAcessToken()->delete();
                $tokenResult = $user->createToken('MyApp');
                $token = $tokenResult->token;
                $token->save();

                $success['token'] = $tokenResult->accessToken;
                $user->device_id = $request->device_id;
                $user->app = $request->app;
                $user->save();

                return response()->json(['success' => $success, 'code' => $this->successStatus], $this->successStatus);
            } else {
                return response()->json(['error' => 'wrong phone or password', 'code' => 401], 401);
            }
        } else {
            return response()->json(['error' => 'wrong phone or password', 'code' => 401], 401);
        }
    }
    /** 
     * Check if user already registered. 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function registerstep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors(), 'code' => 401], 401);
        }

        return response()->json(['msg' => "Not registered", 'code' => 200], 200);
    }

    public function registerstep2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'pin' => 'required|string|max:4|min:4',
            'device_id' => 'required|string',
            'app' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        $validated_user = $this->validate_number($request->phone);
        if ($validated_user == NULL) {
            return response()->json(['error' => "Not found in firebase this request outside of the app", 'code' => 300], 300);
        } else {
            $salt = $this->genrate_salt();
            $password = $this->hash_new_password($request->password, $salt);
            $account_number = random_int(10000000000001, 99999999999999);

            $user = new User([
                'account_number' => $account_number,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => $password,
                'salt' => $salt,
                'phone' => $request->phone,
                'pin' => $request->pin,
                'device_id' => $request->device_id,
                'app' => $request->app,
            ]);
            $user->save();

            $wallet = new Wallet([
                'user_id' => $user->id,
            ]);
            $wallet->save();

            $tokenResult = $user->createToken('MyApp');
            $token = $tokenResult->token;
            $token->save();

            return response()->json([
                'code' => 200,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer'
            ], 200);
        }
    }

    /** 
     * details api
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $user = Auth::user();
        $wallet = $user->wallet;
        $agent = $user->agent;
        $number_of_requests = AppRequest::Where('phone_number', $user->phone)->where('state', 0)->count();
        $user->number_of_requests = $number_of_requests;
        return response()->json(['success' => $user, 'code' => $this->successStatus], $this->successStatus);
    }

    /** 
     * details api
     * 
     * @return \Illuminate\Http\Response 
     */
    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();
        $profile_image_url = $user->profile_picture;
        if ($request->profile_picture) {
            $profile_picture = $request->file('profile_picture');
            $profileImageSaveAsName = time() . $user->id . "-profile." . $profile_picture->getClientOriginalExtension();
            $upload_path = 'profile_pictures/';
            $profile_image_url = $upload_path . $profileImageSaveAsName;
            $success = $profile_picture->move($upload_path, $profileImageSaveAsName);
        }
        $user->profile_picture = $profile_image_url;
        $user->save();
        return response()->json(['success' => True, 'code' => $this->successStatus], $this->successStatus);
    }

    protected function validate_number($phone)
    {
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/secret/zerocash-f4237-firebase-adminsdk-jmxhx-cd0069775a.json');
        $firebase = (new Factory)->withServiceAccount($acc)->create();
        $auth = $firebase->getAuth();
        try {
            $authedUser = $auth->getUserByPhoneNumber($phone);
        } catch (\Throwable $th) {
            return Null;
        }
        return $authedUser;
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

    /****************************************************************************************/

    public function edit(Request $request)
    {
        $user = Auth::user();
        $client = $user;

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }

        $client->full_name = $request->full_name;

        if ($client->email != $request->email) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|unique:users'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
            }

            $client->email = $request->email;
        }

        if ($client->phone != $request->phone) {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|string|unique:users'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
            }

            if ($this->validate_number($request->phone) == Null) {
                return response()->json(['error' => "Not found in firebase this request outside of the app", 'code' => 300], 300);
            } else {
                $client->phone = $request->phone;
            }
        }

        $client->save();
        return response()->json(['success' => $client, 'code' => 200], 200);
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

    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'device_id' => 'required|string',
            'access_token' => 'required|string',
            'firebase_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'code' => 401], 401);
        }

        if ($this->validate_number_forget($request->access_token, $request->phone) == NULL) {
            return response()->json(['error' => "Not found in firebase this request outside of the app", 'code' => 300], 300);
        } else {
            $salt = $this->genrate_salt();
            $password = $this->hash_new_password($request->password, $salt);

            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                $user->password = $password;
                $user->salt = $salt;
                $user->device_id = $request->device_id;
                $user->firebase_token = $request->firebase_token;
                $user->save();

                $wallet = $user->wallet;

                $this->sendNotification("Wellcome Back!", "Your password changed successfully!", $user, 0);
                return response()->json(['success' => $user, 'code' => $this->successStatus], $this->successStatus);
            } else {
                return response()->json(['error' => "Wrong user!", 'code' => 401], 401);
            }
        }
    }

    protected function validate_number_forget($firebase_token, $phone)
    {
        $acc = ServiceAccount::fromJsonFile(__DIR__ . '/secret/zerocash-f4237-firebase-adminsdk-jmxhx-cd0069775a.json');
        $firebase = (new Factory)->withServiceAccount($acc)->create();
        $auth = $firebase->getAuth();
        try {
            try {
                $verifiedIdToken = $auth->verifyIdToken($firebase_token);
            } catch (\InvalidArgumentException $e) {
                echo 'The token could not be parsed: ' . $e->getMessage();
            } catch (InvalidToken $e) {
                echo 'The token is invalid: ' . $e->getMessage();
            }
            $uid = $verifiedIdToken->getClaim('sub');
            $user = $auth->getUser($uid);
            if ($user->phoneNumber == $phone)
                return True;
            return Null;
        } catch (\Throwable $th) {
            return Null;
        }
        return True;
    }

    public function firebase_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }

        $user = Auth::user();
        $user->firebase_token = $request->firebase_token;
        $user->save();
        return response()->json(['success' => 'done!', 'code' => $this->successStatus], $this->successStatus);
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->AauthAcessToken()->delete();
            return response()->json(['success' => 'done!', 'code' => $this->successStatus], $this->successStatus);
        }
    }

    public function check_pin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }
        $user = Auth::user();
        if ($user->pin == $request->pin)
            return response()->json(['success' => True, 'code' => $this->successStatus], $this->successStatus);
        return response()->json(['error' => "Wrong pin!", 'code' => 401], 401);
    }

    public function editAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'code' => 401], 401);
        }
        $user = Auth::user();
        $agent = $user->agent;
        if ($agent) {
            $agent->business_name = $request->business_name;
            $agent->save();
            return response()->json(['success' => $agent, 'code' => $this->successStatus], $this->successStatus);
        } else
            return response()->json(['error' => "No Agent!", 'code' => 401], 401);
    }

    public function updateBusinessLogo(Request $request)
    {
        $user = Auth::user();
        $agent = $user->agent;
        if ($agent) {
            $business_image_url = $agent->business_logo;
            if ($request->business_logo) {
                $business_logo = $request->file('business_logo');
                $profileImageSaveAsName = time() . $agent->id . "-business." . $business_logo->getClientOriginalExtension();
                $upload_path = 'agent_logos/';
                $business_image_url = $upload_path . $profileImageSaveAsName;
                $success = $business_logo->move($upload_path, $profileImageSaveAsName);
            }
            $agent->business_logo = $business_image_url;
            $agent->save();
            return response()->json(['success' => True, 'code' => $this->successStatus], $this->successStatus);
        } else
            return response()->json(['error' => "No Agent!", 'code' => 401], 401);
    }
}
