<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeBank;
use App\Models\EmployeeDocument;
use App\Models\EmployeeEmergencyContact;
use App\Models\EmployeeJob;
use App\Models\EmployeePayslip;
use App\Models\EmployeeProject;
use App\Models\EmployeeVisa;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $title = 'user Profile';
        if (Auth::check() && Auth::user()->role->name != Role::SUPERADMIN) {
            $employee = Employee::with('department', 'designation', 'country', 'branch')->where('user_id', '=', Auth::user()->id)->first();
            $emergency_contact = EmployeeEmergencyContact::where('employee_id', '=', $employee->id)->first();
            $employee_bank = EmployeeBank::where('employee_id', '=', $employee->id)->first();
            $employee_addresses = EmployeeAddress::where('employee_id', '=', $employee->id)->latest()->get();
            $employee_documents = EmployeeDocument::where('employee_id', '=', $employee->id)->latest()->get();
            $employee_jobs = EmployeeJob::with('department')->where('employee_id', '=', $employee->id)->latest()->get();
            $job_title = EmployeeJob::where('employee_id','=',$employee->id)->latest()->value('job_title');
            $employee_visas = EmployeeVisa::where('employee_id', '=', $employee->id)->latest()->get();
            $employee_projects = EmployeeProject::with('projects')->where('employee_id', '=', $employee->id)->get();
            $employee_payslips = EmployeePayslip::where('employee_id', '=', $employee->id)->latest()->get();
            return view('backend.profile', compact('title', 'employee', 'emergency_contact', 'employee_bank', 'employee_addresses', 'employee_documents', 'employee_jobs', 'employee_visas','employee_projects','employee_payslips','job_title'));
        } else {
            return view('backend.profile', compact('title'));
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150|min:5',
            'username' => 'required|max:20|min:3',
            'email' => 'required|email',
            'avatar' => 'file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $imageName = auth()->user()->avatar;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }
        auth()->user()->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
        ]);
        return back()->with('success', "user info has been updated");
    }

    public function empProfileUpdate(Request $request)
    {
          $this->validate($request, [
            'avatar' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $user = User::find($request->employee_id);
        $imageName = $user->avatar;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }
        $user->update([
          'avatar' => $imageName,
        ]);

        $employee = Employee::where('user_id','=',$request->employee_id)->first();
        $employee->avatar = $imageName;
        $employee->save();

        return back()->with('success',"User Profile Image updated Successfully.");
    }
}
