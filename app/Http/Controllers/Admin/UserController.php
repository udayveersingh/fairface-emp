<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "users";
        $users = User::where('role_id', '!=', '1')->get();
        $roles = DB::table('roles')->where('name', '!=', 'Super admin')->where('name', '!=', 'Admin')->get();
        $countries = Country::get();
        return view('backend.users', compact(
            'title',
            'users',
            'roles',
            'countries',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'username' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|max:200|min:5',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $imageName = null;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        $user = User::create([
            'name' => $request->firstname . " " . $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $imageName,
            'role_id' => $request->role_id,
        ]);

        $uuid = IdGenerator::generate(['table' => 'employees', 'field' => 'uuid', 'length' => 7, 'prefix' => 'EMP-']);
        $employee = Employee::create([
            'uuid' => $uuid,
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'marital_status' => $request->input('marital_status'),
            'record_status' => $request->input('record_status'),
            'country_id' => $request->input('nationality'),
            'employee_id' => $request->input('employee_id'),
            'user_id' => $user->id,
        ]);
        $user->notify(new NewUserNotification($user));
        return back()->with('success', "New user has been added");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'username' => 'required|max:10',
            'email' => 'required|email',
            'password' => 'nullable|confirmed|max:200|min:5',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $user = User::findOrFail($request->id);
        $imageName = $user->avatar;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        $password = $user->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'avatar' => $imageName,
        ]);
        return back()->with('success', "User has been updated!!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        return back()->with('success', "User has been deleted successfully!!");
    }
}
