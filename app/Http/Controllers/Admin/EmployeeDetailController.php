<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeBank;
use App\Models\EmployeeDocument;
use App\Models\EmployeeEmergencyContact;
use App\Models\EmployeeJob;
use App\Models\EmployeePayslip;
use App\Models\EmployeeProject;
use App\Models\EmployeeVisa;
use App\Models\Project;
use App\Models\Visa;
use Illuminate\Http\Request;

class EmployeeDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title = 'Employee Detail';
        $employee = Employee::with('department', 'designation')->find($id);
        $designations = Designation::get();
        $departments = Department::get();
        return view('backend.employee-detail', compact('employee', 'title', 'departments', 'designations'));
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function EmergencyContact($id)
    {
        $title = 'Emergency Contact';
        $employee = Employee::find($id);
        $emergency_contact = EmployeeEmergencyContact::where('employee_id', '=', $employee->id)->first();
        return view('backend.employee-details.contact', compact('title', 'employee', 'emergency_contact'));
    }

    /**
     * Display a listing of the resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function EmployeeAddress($id)
    {
        $title = 'Employee Address';
        $employee = Employee::find($id);
        $employee_address = EmployeeAddress::where('employee_id', '=', $employee->id)->first();
        return view('backend.employee-details.address', compact('title', 'employee', 'employee_address'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function EmployeeBank($id)
    {
        $title = 'Employee Bank';
        $employee = Employee::find($id);
        $employee_bank = EmployeeBank::where('employee_id', '=', $employee->id)->first();
        return view('backend.employee-details.bank', compact('title', 'employee', 'employee_bank'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function EmployeeVisa($id)
    {
        $title = 'Employee Visa';
        $employee = Employee::find($id);
        $visa_types = Visa::get();
        $employee_visas = EmployeeVisa::where('employee_id', '=', $employee->id)->latest()->get();
        return view('backend.employee-details.visa', compact('title', 'employee', 'employee_visas', 'visa_types'));
    }
    public function EmployeeProject($id)
    {
        $title = 'Employee Project';
        $employee = Employee::find($id);
        $projects = Project::where('status', '=', 1)->get();
        $employee_projects = EmployeeProject::with('projects')->where('employee_id', '=', $employee->id)->get();
        return view('backend.employee-details.project', compact('title', 'employee', 'employee_projects', 'projects'));
    }


    public function EmployeeJob($id)
    {
        $title = "Employee Job";
        $employees = Employee::get();
        $departments  = Department::get();
        $employee = Employee::find($id);
        $employee_jobs  = EmployeeJob::where('employee_id', '=', $employee->id)->latest()->get();
        return view('backend.employee-details.job', compact('title', 'employee', 'employee_jobs', 'employees', 'departments'));
    }

    public function EmployeePayslip($id)
    {
        $title = 'Employee Payslip';
        $employee = Employee::find($id);
        $employee_payslips = EmployeePayslip::where('employee_id', '=', $employee->id)->latest()->get();
        return view('backend.employee-details.payslip', compact('title', 'employee', 'employee_payslips'));
    }


    public function EmployeePayslipUpload(Request $request)
    {
        $this->validate($request, [
            'month' => 'required',
            'year' => 'required',
        ]);
        $file = null;
        $file_name = "";
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->extension();
            $file->move(public_path('storage/payslips/'), $file_name);
        }
        $Employee_payslip = new EmployeePayslip;
        $Employee_payslip->employee_id = $request->emp_id;
        $Employee_payslip->month = $request->month;
        $Employee_payslip->year = $request->year;
        $Employee_payslip->attachment = $file_name;
        $Employee_payslip->save();
        // $getEmployeeSlips = EmployeePayslip::where('employee_id', '=', $request->emp_id)->get();
        return response()->json([
            // 'data' => $getEmployeeSlips,
        ]);
    }


    public function EmployeeDocument($id)
    {
        $title = 'Employee Document';
        $employee = Employee::find($id);
        $employee_documents = EmployeeDocument::where('employee_id', '=', $employee->id)->latest()->get();
        return view('backend.employee-details.document', compact('title', 'employee', 'employee_documents'));
    }


    public function EmployeeDocumentUpload(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $file = null;
        $file_name = "";
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $file_name = time() . '.' . $file->extension();
            $file->move(public_path('storage/documents/employee/' . $request->emp_id), $file_name);
        }
        $Employee_document = new EmployeeDocument;
        $Employee_document->employee_id = $request->emp_id;
        $Employee_document->name = $request->name;
        $Employee_document->attachment = $file_name;
        $Employee_document->save();
        // $getEmployeeSlips = EmployeePayslip::where('employee_id', '=', $request->emp_id)->get();
        return response()->json([
            // 'data' => $getEmployeeSlips,
        ]);
    }
}
