<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Branches";
        $branches = Branch::get();
        return view('backend.branches', compact('title', 'branches'));
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
            'branch_code' => 'required|max:100',
            'branch_address' => 'required|max:200',
        ]);

        Branch::create($request->all());
        return back()->with('success', "Branch has been added successfully!!.");
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
            'branch_code' => 'required|max:100',
            'branch_address' => 'required|max:200',
        ]);
        $branch = Branch::find($request->id);
        $branch->update([
            'branch_code' => $request->branch_code,
            'branch_address' => $request->branch_address,
        ]);
        return back()->with('success', "Branch has been updated successfully!!.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $branch = Branch::find($request->id);
        $branch->delete();
        return back()->with('success', "Branch has been deleted successfully!!.");
    }
}
