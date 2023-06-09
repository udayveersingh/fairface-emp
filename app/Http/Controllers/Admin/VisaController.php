<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visa;
use Illuminate\Http\Request;

class VisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Visas";
        $visas = Visa::orderBy('created_at','desc')->get();
               return view('backend.visa', compact('title', 'visas'));
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
            'visa_type' => 'unique:visas,visa_type|required|max:100',
        ]);

        Visa::create($request->all());
        return back()->with('success', "Visa has been added successfully!!.");
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
            'visa_type' => 'required|max:100|unique:visas,visa_type,' . $request->id,
        ]);
        $visa = Visa::find($request->id);
        $visa->update([
            'visa_type' => $request->visa_type,
        ]);
        return back()->with('success', "Visa has been updated successfully!!.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $visa = Visa::find($request->id);
        $visa->delete();
        return back()->with('success', "Visa has been deleted successfully!!.");
    }
}
