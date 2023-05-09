<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeePayslip;
use Illuminate\Http\Request;

class EmployeePayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = "Employee Payslip";
        $employee_payslips = EmployeePayslip::get();
        return view('backend.employee-payslip', compact('title', 'employee_payslips', 'empId'));
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
            'month' => 'required',
            'year' => 'required',
        ]);

        $file = null;
        $file_name ="";
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->extension();
            $file->move(public_path('storage/payslips/'), $file_name);
        }

        EmployeePayslip::create([
            'employee_id' => $request->emp_id,
            'month' => $request->month,
            'year'  => $request->year,
            'attachment' => $file_name,
        ]);

        $notification = notify('Employee PaySlip has been added');
        return back()->with($notification);
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
            'month' => 'required',
            'year' => 'required',
        ]);
        $file = null;
        $file_name ="";
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->extension();
            $file->move(public_path('storage/payslips/'), $file_name);
        }

         $Employee_payslip = EmployeePayslip::find($request->id);
         $Employee_payslip->update([
            'employee_id' => $request->emp_id,
            'month' => $request->month,
            'year'  => $request->year,
            'attachment' => $file_name,
        ]);
        $notification = notify('Employee PaySlip has been updated');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_payslip = EmployeePayslip::find($request->id);
        $employee_payslip->delete();
        return back()->with('success',"Employee Payslip has been deleted.");
    }
}
