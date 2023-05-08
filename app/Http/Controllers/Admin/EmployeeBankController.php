<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeBank;
use Illuminate\Http\Request;

class EmployeeBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $empId = $id;
        $title = "Employee Bank";
        $employee_banks = EmployeeBank::get();
        return view('backend.employee-bank', compact('title', 'employee_banks', 'empId'));
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
            'bank_name' => 'nullable|max:80',
            'account_number' => 'nullable|max:100',
            'ifsc_code' => 'nullable|max:50',
        ]);
        EmployeeBank::create([
            'employee_id' => $request->emp_id,
            'account_name' => $request->account_name,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->account_number,
            'bank_sort_code' => $request->bank_sort_code,
            'ifsc_code' => $request->ifsc_code,
        ]);
        return back()->with('success', "Employee Bank has been added successfully.");
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
            'bank_name' => 'nullable|max:80',
            'account_number' => 'nullable|max:100',
            'ifsc_code' => 'nullable|max:50',
        ]);

        $employee_bank = EmployeeBank::find($request->id);
        $employee_bank->update([
            'employee_id' => $request->emp_id,
            'account_name' => $request->account_name,
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->account_number,
            'bank_sort_code' => $request->bank_sort_code,
            'ifsc_code' => $request->ifsc_code,
        ]);
        return back()->with('success', "Employee Bank has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee_bank = EmployeeBank::find($request->id);
        $employee_bank->delete();
        return back()->with('success',"Employee bank has been deleted.");
    }
}
