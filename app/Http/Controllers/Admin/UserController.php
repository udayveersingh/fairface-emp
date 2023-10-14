<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $users = User::with('role')->whereHas('role', function (Builder $query) {
            $query->where('name', '!=', Role::SUPERADMIN);
        })->get();
        // $roles = DB::table('roles')->where('name', '!=', 'Super admin')->where('name', '!=', 'Admin')->get();
        $countries = Country::get();
        return view('backend.users', compact('title', 'users', 'countries'));
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
            'username' => 'required|max:50',
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
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'username' => 'required|max:50',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'password' => 'nullable|confirmed|max:200|min:5',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $user = User::findOrFail($request->id);
        $imageName = $user->avatar;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }
        $password = $user->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }
        $user->update([
            'name' => $request->firstname . " " . $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'avatar' => $imageName,
            'role_id' => $request->role_id,
        ]);
        $status_change_date = Null;
        if ($request->record_status != 'active') {
            $status_change_date =  date('Y-m-d');
        }

        $uuid = IdGenerator::generate(['table' => 'employees', 'field' => 'uuid', 'length' => 7, 'prefix' => 'EMP-']);

        if(!empty($request->emp_id)){
            $employee = Employee::find($request->emp_id);
        }else{
            $employee = new Employee;
            $employee->uuid = $uuid;
        }
        $employee->firstname = $request->input('firstname');
        $employee->lastname = $request->input('lastname');
        $employee->email = $request->input('email');
        $employee->marital_status = $request->input('marital_status');
        $employee->record_status = $request->input('record_status');
        $employee->country_id = $request->input('nationality');
        $employee->employee_id = $request->input('employee_id');
        $employee->status_change_date = $status_change_date;
        $employee->user_id = $user->id;
        $employee->avatar = $imageName;
        $employee->save();
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
