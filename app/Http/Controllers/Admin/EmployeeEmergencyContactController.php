<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeEmergencyContact;
use Illuminate\Http\Request;

class EmployeeEmergencyContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = "Emergency Contact";
        $emergency_contacts = EmployeeEmergencyContact::get();
        return view('backend.emergency-contact', compact('title', 'emergency_contacts','empId'));
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
            'name'=>'required|max:15',
            'address' => 'required|max:200', 
            'overseas_name' => 'required|max:15',
            'overseas_address' => 'required|max:200',
            'phone_number_1' => 'nullable|max:15',
            'phone_number_2' => 'nullable|max:15',
            'overseas_phone_number_1' => 'nullable|max:15',
            'overseas_phone_number_2' => 'nullable|max:15',
         ]);

         EmployeeEmergencyContact::create([
            'full_name'=>$request->name,
            'employee_id' => $request->emp_id,
            'address'=>$request->address,
            'phone_number_1'=>$request->phone_number_1,
            'phone_number_2'=>$request->phone_number_2,
            'relationship'=>$request->relationship,
            'overseas_full_name'=>$request->overseas_name,
            'overseas_address'=>$request->overseas_address,
            'overseas_phone_number_1'=>$request->overseas_phone_number_1,
            'overseas_phone_number_2'=>$request->overseas_phone_number_2,
            'overseas_relationship'=>$request->overseas_relationship,
        ]);
        return back()->with('success',"Employee Emergency Contact has been added successfully.");



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeEmergencyContact  $employeeEmergencyContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:15',
            'address' => 'required|max:200', 
            'overseas_name' => 'required|max:15',
            'overseas_address' => 'required|max:200',
            'phone_number_1' => 'nullable|max:15',
            'phone_number_2' => 'nullable|max:15',
            'overseas_phone_number_1' => 'nullable|max:15',
            'overseas_phone_number_2' => 'nullable|max:15',
         ]);

         $Employee_emergency_contact = EmployeeEmergencyContact::find($request->id);
         $Employee_emergency_contact->update([
            'full_name'=>$request->name,
            'employee_id' => $request->emp_id,
            'address'=>$request->address,
            'phone_number_1'=>$request->phone_number_1,
            'phone_number_2'=>$request->phone_number_2,
            'relationship'=>$request->relationship,
            'overseas_full_name'=>$request->overseas_name,
            'overseas_address'=>$request->overseas_address,
            'overseas_phone_number_1'=>$request->overseas_phone_number_1,
            'overseas_phone_number_2'=>$request->overseas_phone_number_2,
            'overseas_relationship'=>$request->overseas_relationship,
        ]);
        return back()->with('success',"Employee Emergency contact has been updated.");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeEmergencyContact  $employeeEmergencyContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $emp_emergency_contact = EmployeeEmergencyContact::find($request->id);
        $emp_emergency_contact->delete();
        return back()->with('success',"Employee Emergency contact has been deleted.");
    }
}
