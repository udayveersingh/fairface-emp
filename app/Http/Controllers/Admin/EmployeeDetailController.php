<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeBank;
use App\Models\EmployeeEmergencyContact;
use App\Models\EmployeeJob;
use App\Models\EmployeeProject;
use App\Models\EmployeeVisa;
use App\Models\Project;
use App\Models\Visa;
use Illuminate\Http\Request;

class EmployeeDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = 'Employee Detail';
        $employee = Employee::with('department','designation')->find($id);
        $designations = Designation::get();
        $departments = Department::get();
        return view('backend.employee-detail',compact('employee','title','departments','designations'));
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function EmergencyContact($id)
    {
        $title = 'Emergency Contact';
        $employee = Employee::find($id);
        $emergency_contact = EmployeeEmergencyContact::where('employee_id','=',$employee->id)->first();
        return view('backend.employee-details.contact',compact('title','employee','emergency_contact'));
    }

    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function EmployeeAddress($id)
    {
        $title = 'Employee Address';
        $employee = Employee::find($id);
        $employee_address = EmployeeAddress::where('employee_id','=',$employee->id)->first();
        return view('backend.employee-details.address',compact('title','employee','employee_address'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function EmployeeBank($id)
    {
        $title = 'Employee Bank';
        $employee = Employee::find($id);
        $employee_bank = EmployeeBank::where('employee_id','=',$employee->id)->first();
        return view('backend.employee-details.bank',compact('title','employee','employee_bank'));
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function EmployeeVisa($id)
   {
       $title = 'Employee Visa';
       $employee = Employee::find($id);
       $visa_types = Visa::get();
       $employee_visa = EmployeeVisa::where('employee_id','=',$employee->id)->first();
       return view('backend.employee-details.visa',compact('title','employee','employee_visa','visa_types'));
   }
   public function EmployeeProject($id)
   {
       $title = 'Employee Project';
       $employee = Employee::find($id);
       $projects = Project::where('status','=',1)->get();
       $employee_project = EmployeeProject::where('employee_id','=',$employee->id)->first();
       return view('backend.employee-details.project',compact('title','employee','employee_project','projects'));
   }


   public function EmployeeJob($id)
   {
    $title = "Employee Job";
    $employees = Employee::get();
    $departments  = Department::get();
    $employee = Employee::find($id);
    $employee_job = EmployeeJob::where('employee_id','=',$employee->id)->first();
    return view('backend.employee-details.job',compact('title','employee','employee_job','employees','departments'));
   }     
}
