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
        $empId = $id;
        $title = "Employee Job";
        $employee_jobs = EmployeeJob::get();
        $employees = Employee::get();
        $departments  = Department::get(); 
        return view('backend.employee-job', compact('title', 'employee_jobs', 'employees','departments','empId'));
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
        $request->validate([
            'supervisor' => 'required',
            'job_title' => 'required',
            'department' => 'required',
            'work_phone_number' => 'nullable|max:15'
        ]);

        EmployeeJob::create([
            'employee_id' => $request->emp_id,
            'supervisor' => $request->supervisor,
            'timesheet_approval_incharge' => $request->timesheet_approval_inch,
            'department_id' => $request->department,
            'job_title' => $request->job_title,
            'work_email' => $request->work_email,
            'work_phone_number' => $request->work_phone_number,
            'start_date' => $request->start_date,
            'job_type'=> $request->job_type,
            'contracted_weekly_hours' => $request->contract_weekly_hours,
        ]);
        return back()->with('success', "Employee Job has been added successfully.");
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

        $request->validate([
            'supervisor' => 'required',
            'job_title' => 'required',
            'department' => 'required',
        ]);

        $employee_job = EmployeeJob::find($request->id);
        $employee_job->update([
            'employee_id' => $request->emp_id,
            'supervisor' => $request->supervisor,
            'timesheet_approval_incharge' => $request->timesheet_approval_inch,
            'department_id' => $request->department,
            'job_title' => $request->job_title,
            'work_email' => $request->work_email,
            'work_phone_number' => $request->work_phone_number,
            'start_date' => $request->start_date,
            'job_type'=> $request->job_type,
            'contracted_weekly_hours' => $request->contract_weekly_hours,
        ]);
        return back()->with('success', "Employee Job has been Updated successfully.");
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
        return back()->with('success',"Employee job has been deleted");
    }
}
