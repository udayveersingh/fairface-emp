<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeDocument;
use App\Models\EmployeeVisa;
use App\Models\Visa;
use Illuminate\Http\Request;

class EmployeeVisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = "Employee visa";
        $visa_types = Visa::get();
        $employee_visas = EmployeeVisa::with('visa_types')->get();
        return view('backend.employee-visa', compact('title', 'employee_visas','visa_types', 'empId'));
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
        // dd($request->all());
        $this->validate($request, [
            'visa_type' => 'required',
            'visa_issue_date' => 'required',
            'visa_expiry_date'=> 'required'
            // 'cos_number' => 'required|max:100',

        ]);
        EmployeeVisa::create([
            'employee_id' => $request->emp_id,
            'visa_type' => $request->visa_type,
            'cos_number' => $request->cos_number,
            'cos_issue_date' => $request->cos_issue_date,
            'cos_expiry_date' => $request->cos_expiry_date,
            'visa_issue_date' => $request->visa_issue_date,
            'visa_expiry_date' => $request->visa_expiry_date,
        ]);
        return back()->with('success', "Your record saved!");
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
            'visa_type' => 'required',
            'visa_issue_date' => 'required',
            'visa_expiry_date'=> 'required'
            // 'cos_number' => 'required|max:100',
        ]);

        $employee_visa = EmployeeVisa::find($request->edit_id);
        $employee_visa->update([
            'employee_id' => $request->emp_id,
            'visa_type' => $request->visa_type,
            'cos_number' => $request->cos_number,
            'cos_issue_date' => $request->cos_issue_date,
            'cos_expiry_date' => $request->cos_expiry_date,
            'visa_issue_date' => $request->visa_issue_date,
            'visa_expiry_date' => $request->visa_expiry_date,
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
        $employee_visa = EmployeeVisa::find($request->id);
        $employee_visa->delete();
        return back()->with('success',"Employee Visa has been deleted.");
    }
}
