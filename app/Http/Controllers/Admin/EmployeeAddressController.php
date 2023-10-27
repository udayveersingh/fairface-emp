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
        return view('backend.employee-address', compact('title', 'employee_addresses', 'empId'));
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
            'address_line_1' => 'required',
        ]);
        EmployeeAddress::create([
            'employee_id' => $request->emp_id,
            'address_type' => $request->address_type,
            'home_address_line_1' => $request->address_line_1,
            'home_address_line_2' => $request->address_line_2,
            'post_code' => $request->post_code,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ]);
        return back()->with('success', "Employee Address has been added successfully.");
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
            'address_line_1' => 'required',
        ]);
        if (!empty($request->id)) {
            $Employee_emergency_contact = EmployeeAddress::find($request->id);
            $message = "Employee Address has been updated.";
        } else {
            $Employee_emergency_contact = new EmployeeAddress();
            $message = "Employee Address has been created.";
        }
        $Employee_emergency_contact->employee_id = $request->input('emp_id');
        $Employee_emergency_contact->address_type = $request->address_type;
        $Employee_emergency_contact->home_address_line_1 = $request->input('address_line_1');
        $Employee_emergency_contact->home_address_line_2 = $request->input('address_line_2');
        $Employee_emergency_contact->post_code = $request->input('post_code');
        $Employee_emergency_contact->from_date = $request->input('from_date');
        $Employee_emergency_contact->to_date = $request->input('to_date');
        $Employee_emergency_contact->save();
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
        $employee_address = EmployeeAddress::find($request->id);
        $employee_address->delete();
        return back()->with('success', "Employee Address has been deleted.");
    }
}
