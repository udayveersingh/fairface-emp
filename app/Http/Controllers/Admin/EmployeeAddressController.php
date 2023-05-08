<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAddress;
use Illuminate\Http\Request;

class EmployeeAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = "Employee Address";
        $employee_addresses = EmployeeAddress::get();
        return view('backend.employee-address', compact('title', 'employee_addresses','empId'));
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
        $this->validate($request,[
            'address_line_1' => 'required',
            'from_date'=>'required', 
         ]);
        EmployeeAddress::create([
            'employee_id' => $request->emp_id,
            'home_address_line_1'=>$request->address_line_1,
            'home_address_line_2'=>$request->address_line_2,
            'post_code'=>$request->post_code,
            'from_date'=>$request->from_date,
            'to_date'=>$request->to_date,
        ]);
        return back()->with('success',"Employee Address has been added successfully.");
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
        $this->validate($request,[
            'address_line_1' => 'required',
            'from_date'=>'required', 
         ]);

         $Employee_emergency_contact = EmployeeAddress::find($request->id);
         $Employee_emergency_contact->update([
            'employee_id' => $request->emp_id,
            'home_address_line_1'=>$request->address_line_1,
            'home_address_line_2'=>$request->address_line_2,
            'post_code'=>$request->post_code,
            'from_date'=>$request->from_date,
            'to_date'=>$request->to_date,
        ]);
        return back()->with('success',"Employee Address has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_address = EmployeeAddress::find($request->id);
        $employee_address->delete();
        return back()->with('success',"Employee Address has been deleted.");
    }
}
