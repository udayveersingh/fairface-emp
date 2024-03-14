<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employee = Employee::select('user_id', 'firstname', 'lastname', 'email', 'phone', 'date_of_birth', 'record_status', 'marital_status', 'avatar')->where('user_id', '=', $user->id)->first();
            $userImage = $employee->avatar;
            if (!empty($userImage)) {
                if (file_exists(public_path() . '/storage/employees/' . $userImage)) {
                    $employee['avatar'] = asset('/storage/employees/' . $userImage);
                }
            }
            return response()->json([
                'success' => true,
                'data' => $employee
            ], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json([
                    'success' => false,
                    'message' =>  $error
                ], 400);
            }
            $user = User::find($user->id);
            $imageName = $user->avatar;
            if ($request->hasFile('avatar')) {
                $imageName = time() . '.' . $request->avatar->extension();
                $request->avatar->move(public_path('storage/employees'), $imageName);
            }

            $user->update([
                'name' => $request->firstname . " " . $request->lastname,
                'username' => $request->firstname . " " . $request->lastname,
                'email' => $request->email,
                'avatar' => $imageName,
            ]);

            $employee = Employee::select('user_id', 'firstname', 'lastname', 'email', 'phone', 'date_of_birth', 'record_status', 'marital_status', 'avatar')->where('user_id', '=', $user->id)->first();
            $employee->firstname = $request->input('firstname');
            $employee->lastname = $request->input('lastname');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            if ($request->input('marital_status')) {
                $employee->marital_status = $request->input('marital_status');
            }
            if ($request->input('record_status')) {
                $employee->record_status = $request->input('record_status');
            }
            if ($request->input('date_of_birth')) {
                $employee->date_of_birth = $request->input('date_of_birth');
            }
            $employee->avatar = $imageName;
            $employee->save();
            $userImage = $employee->avatar;
            if (!empty($userImage)) {
                if (file_exists(public_path() . '/storage/employees/' . $userImage)) {
                    $employee['avatar'] = asset('/storage/employees/' . $userImage);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully.',
                'data' => $employee
            ], 201);
        }
    }
}
