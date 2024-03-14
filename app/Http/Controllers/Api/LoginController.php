<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' =>  $error
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $userImagePath = "";
            $userImage = $user->avatar;
            if (!empty($userImage)) {
                if (file_exists(public_path() . '/storage/employees/' . $userImage)) {
                    $userImagePath = asset('/storage/employees/' . $userImage);
                }
            }
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'User Login Successfully.',
                'success' => true,
                'name' => $user->name,
                'image' => $userImagePath,
                'access_token' => $token,
            ], 201);
        } else {
            return response()->json(["success" => false, "message" => 'No user found.'], 404);
        }
    }


    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 201);
    }
}
