<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimesheetStatus;
use Illuminate\Http\Request;

class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Timesheet Status";
        $timesheet_statuses = TimesheetStatus::orderBy('created_at','desc')->get();
        return view('backend.timesheet-status', compact('title', 'timesheet_statuses'));
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
            'timesheet_status' => 'required',
        ]);

        TimesheetStatus::create([
            'status' => $request->timesheet_status,
        ]);
        return back()->with('success', "TimeSheet Status has been added successfully!!.");
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
            'timesheet_status' => 'required',
        ]);
        $timesheet_status = TimesheetStatus::find($request->id);
        $timesheet_status->update([
            'status' => $request->timesheet_status,
        ]);
        return back()->with('success', "Timesheet Status has been updated successfully!!.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $timesheet_status = TimesheetStatus::find($request->id);
        $timesheet_status->delete();
        return back()->with('success', "TimeSheet has been deleted successfully!!.");
    }
}
