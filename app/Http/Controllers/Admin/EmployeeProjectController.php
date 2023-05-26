<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeProject;
use App\Models\Project;
use Illuminate\Http\Request;

class EmployeeProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = 'Employee Project';
        $projects = Project::where('status','=',1)->get();
        $employee_projects = EmployeeProject::with('projects')->get();
        return view('backend.employee-project',compact('title','employee_projects','empId','projects'));
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
        $this->validate($request, [
            'start_date' => 'required',
        ]);
        EmployeeProject::create([
            'employee_id' => $request->emp_id,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'project_id'    => $request->project,
        ]);
        return back()->with('success', "Your record saved!");
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
            'start_date' => 'required',
        ]);

        $employee_project = EmployeeProject::find($request->edit_id);
        $employee_project->update([
            'employee_id' => $request->emp_id,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'project_id'    => $request->project,
        ]);
        return back()->with('success', "Your record updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_project = EmployeeProject::find($request->id);
        $employee_project->delete();
        return back()->with('success',"Employee Project has been deleted.");
    }
}
