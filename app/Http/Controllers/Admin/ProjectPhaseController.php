<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectPhase;
use Illuminate\Http\Request;

class ProjectPhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Project Phase";
        $project_phases = ProjectPhase::orderBy('created_at','desc')->get();
        return view('backend.project-phase', compact('title', 'project_phases'));
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
            'project_phase' => 'required',
        ]);

        ProjectPhase::create([
            'name' => $request->project_phase,
        ]);
        return back()->with('success', "Project Phase has been added successfully!!.");
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
            'project_phase' => 'required',
        ]);
        $project_phase = ProjectPhase::find($request->id);
        $project_phase->update([
            'name' => $request->project_phase,
        ]);
        return back()->with('success', "Project Phase has been updated successfully!!.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project_phase = ProjectPhase::find($request->id);
        $project_phase->delete();
        return back()->with('success', "Project Phase has been deleted successfully!!.");
    }
}
