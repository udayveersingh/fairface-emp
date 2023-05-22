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
        return view('backend.emergency-contact', compact('title', 'emergency_contacts', 'empId'));
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
            'name' => 'required',
            'relationship' => 'required',
            'address' => 'required|max:200',
            'overseas_name' => 'required|max:15',
            'overseas_address' => 'required|max:200',
            'phone_number_1' => 'nullable|max:15',
            'phone_number_2' => 'nullable|max:15',
            'overseas_phone_number_1' => 'nullable|max:15',
            'overseas_phone_number_2' => 'nullable|max:15',
        ]);

        EmployeeEmergencyContact::create([
            'full_name' => $request->name,
            'employee_id' => $request->emp_id,
            'address' => $request->address,
            'phone_number_1' => $request->phone_number_1,
            'phone_number_2' => $request->phone_number_2,
            'relationship' => $request->relationship,
            'overseas_full_name' => $request->overseas_name,
            'overseas_address' => $request->overseas_address,
            'overseas_phone_number_1' => $request->overseas_phone_number_1,
            'overseas_phone_number_2' => $request->overseas_phone_number_2,
            'overseas_relationship' => $request->overseas_relationship,
        ]);
        return back()->with('success', "Employee Emergency Contact has been added successfully.");
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
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required|max:200',
            'overseas_name' => 'required|max:15',
            'overseas_address' => 'required|max:200',
            'phone_number_1' => 'nullable|max:15',
            'phone_number_2' => 'nullable|max:15',
            'overseas_phone_number_1' => 'nullable|max:15',
            'overseas_phone_number_2' => 'nullable|max:15',
        ]);

        if (!empty($request->id)) {
            $Employee_emergency_contact = EmployeeEmergencyContact::find($request->id);
            $message =  "Employee Emergency contact has been updated.";
        } else {
            $Employee_emergency_contact = new EmployeeEmergencyContact();
            $message =  "Employee Emergency contact has been Created.";
        }
        $Employee_emergency_contact->full_name = $request->input('name');
        $Employee_emergency_contact->employee_id = $request->input('emp_id');
        $Employee_emergency_contact->address = $request->input('address');
        $Employee_emergency_contact->phone_number_1 = $request->input('phone_number_1');
        $Employee_emergency_contact->phone_number_2 = $request->input('phone_number_2');
        $Employee_emergency_contact->relationship = $request->input('relationship');
        $Employee_emergency_contact->overseas_full_name = $request->input('overseas_name');
        $Employee_emergency_contact->overseas_address = $request->input('overseas_address');
        $Employee_emergency_contact->overseas_phone_number_1 = $request->input('overseas_phone_number_1');
        $Employee_emergency_contact->overseas_phone_number_2 = $request->input('overseas_phone_number_2');
        $Employee_emergency_contact->overseas_relationship = $request->input('overseas_relationship');
        $Employee_emergency_contact->save();
        return back()->with('success', $message);
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
        return back()->with('success', "Employee Emergency contact has been deleted.");
    }
}
