<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeEmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index(){
        $title= 'user Profile';
     if (Auth::check() && Auth::user()->role_id == '3')
     {
        $employee = Employee::with('department', 'designation', 'country', 'branch')->where('user_id','=',Auth::user()->id)->first();
        $emergency_contact = EmployeeEmergencyContact::where('employee_id', '=', $employee->id)->first();
        return view('backend.profile',compact('title','employee','emergency_contact'));
     }else{
        return view('backend.profile',compact('title'));
     }
    }

    public function update(Request $request){
        $this->validate($request,[
            'name' => 'required|max:150|min:5',
            'username' => 'required|max:20|min:3',
            'email' => 'required|email',
            'avatar'=>'file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $imageName = auth()->user()->avatar;
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        auth()->user()->update([
            'name' => $request->name,
            'username'=> $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
        ]);
        return back()->with('success',"user info has been updated");
    }
}
