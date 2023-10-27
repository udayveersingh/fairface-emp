<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\User;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "employees";
        $branches = Branch::get();
        $countries = Country::get();
        $employees = Employee::with('branch', 'user.role')->get();
        return view('backend.employees', compact('title', 'employees', 'branches', 'countries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($status)
    {
        // dd($status);
        $title = "employees";
        $branches = Branch::get();
        $countries = Country::get();
        $employees = Employee::with('branch', 'user.role')->where('record_status', '=', $status)->orderBy('created_at', 'desc')->get();
        // return view('backend.employees.active-employee',compact('title', 'employees', 'branches', 'countries'));

        return view('backend.employees-list', compact('title', 'employees', 'branches', 'countries','status'));
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
            'employee_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|max:25',
            'nat_insurance_number' => 'nullable|max:25',
            'passport_number' => 'nullable|max:25',
            // 'pass_issue_date' => 'required',
            // 'pass_expire_date' => 'required',
            'nationality' => 'required',
            'marital_status' => 'required',
            'record_status' => 'required',
            'role_id' => 'required',
            'password' => 'required|confirmed|max:200|min:5',
            'avatar' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $imageName = Null;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }

        $user = User::create([
            'name' => $request->firstname . " " . $request->lastname,
            'username' =>  $request->firstname . " " . $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'temp_password' => $request->password,
            'avatar' => $imageName,
            'role_id' => $request->role_id,
        ]);

        $uuid = IdGenerator::generate(['table' => 'employees', 'field' => 'uuid', 'length' => 7, 'prefix' => 'EMP-']);
        $employee = Employee::create([
            'uuid' => $uuid,
            'employee_id' => $request->input('employee_id'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'avatar' => $imageName,
            'alternate_phone_number' => $request->input('al_phone_number'),
            'national_insurance_number' => $request->input('nat_insurance_number'),
            'country_id' => $request->input('nationality'),
            'date_of_birth' => $request->input('date_of_birth'),
            'passport_issue_date' => $request->input('pass_issue_date'),
            'passport_expiry_date' => $request->input('pass_expire_date'),
            'marital_status' => $request->input('marital_status'),
            'record_status' => $request->input('record_status'),
            'passport_number' => $request->input('passport_number'),
            'branch_id' => $request->input('branch_id'),
            'user_id' => $user->id,
        ]);
        return redirect()->route('employee-detail', $employee->id)->with('success', "Employee has been added");
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable|max:20',
            'avatar' => 'file|image|mimes:jpg,jpeg,png,gif',
            'nat_insurance_number' => 'nullable|max:25',
            'passport_number' => 'nullable|max:25',
            // 'pass_issue_date' => 'required',
            // 'pass_expire_date' => 'required',
            'nationality' => 'required',
            'marital_status' => 'required',
            'record_status' => 'required',
            'role_id' => 'required',
        ]);
        $employee = Employee::find($request->id);
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        } else {
            $imageName = $employee->avatar;
        }

        $user = User::find($employee->user_id);
        $user->update([
            'name' => $request->firstname . " " . $request->lastname,
            'username' =>  $request->firstname . " " . $request->lastname,
            'email' => $request->email,
            'avatar' => $imageName,
            'role_id' => $request->role_id,
        ]);
        $status_change_date = Null;
        if ($request->record_status != 'active') {
            $status_change_date =  date('Y-m-d');
        }
        $employee->update([
            'uuid' => $employee->uuid,
            'employee_id' => $request->employee_id,
            'branch_id' => $request->branch_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => $imageName,
            'alternate_phone_number' => $request->al_phone_number,
            'national_insurance_number' => $request->nat_insurance_number,
            'country_id' => $request->nationality,
            'date_of_birth' => $request->date_of_birth,
            'passport_issue_date' => $request->pass_issue_date,
            'passport_expiry_date' => $request->pass_expire_date,
            'marital_status' => $request->marital_status,
            'record_status' => $request->record_status,
            'passport_number' => $request->passport_number,
            'status_change_date' => $status_change_date,
            'user_id' => $user->id,
        ]);
        return back()->with('success', "Employee details has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->delete();
        return back()->with('success', "Employee has been deleted");
    }
}
