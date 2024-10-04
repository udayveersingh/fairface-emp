<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeJob;
use Illuminate\Http\Request;

class EmployeeJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // $empId = $id;
        // $title = "Employee Job";
        // $employee_jobs = EmployeeJob::get();
        // $employees = Employee::get();
        // $departments  = Department::get();
        // return view('backend.employee-job', compact('title', 'employee_jobs', 'employees', 'departments', 'empId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'supervisor' => 'required',
        //     'job_title' => 'required',
        //     'department' => 'required',
        //     'work_phone_number' => 'nullable|max:20'
        // ]);
        $employee_job = new EmployeeJob;
        
        $employee_job->employee_id =  $request->emp_id;
        $employee_job->supervisor  =  $request->supervisor;
        $employee_job->timesheet_approval_incharge =  $request->timesheet_approval_inch;
        $employee_job->department_id =  $request->department;
        $employee_job->job_title  =  $request->job_title;
        $employee_job->work_email =  $request->work_email;
        $employee_job->work_phone_number =  $request->work_phone_number;
        $employee_job->start_date =  $request->start_date;
        $employee_job->end_date  = $request->end_date;
        $employee_job->job_type =  $request->job_type;
        $employee_job->salary = $request->salary;
        $employee_job->contracted_weekly_hours =  $request->contract_weekly_hours;
        $employee_job->save();
        return back()->with('success', "Your record saved!");
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
        // $request->validate([
        //     'supervisor' => 'required',
        //     'job_title' => 'required',
        //     'department' => 'required',
        // ]);
        if (!empty($request->edit_id)) {
            $employee_job = EmployeeJob::find($request->edit_id);
            $message = "Employee Job has been Updated successfully.";
        } else {
            $employee_job = new EmployeeJob;
            $message = "Employee Job has been added successfully.";
        }
        $employee_job->employee_id =  $request->emp_id;
        $employee_job->supervisor  =  $request->supervisor;
        $employee_job->timesheet_approval_incharge =  $request->timesheet_approval_inch;
        $employee_job->department_id =  $request->department;
        $employee_job->job_title  =  $request->job_title;
        $employee_job->work_email =  $request->work_email;
        $employee_job->work_phone_number =  $request->work_phone_number;
        $employee_job->start_date =  $request->start_date;
        $employee_job->end_date  = $request->end_date;
        $employee_job->job_type =  $request->job_type;
        $employee_job->salary = $request->salary;
        $employee_job->contracted_weekly_hours =  $request->contract_weekly_hours;
        $employee_job->save();
        return back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_job = EmployeeJob::findOrFail($request->id);
        $employee_job->delete();
        return back()->with('success', "Employee job has been deleted");
    }
}
