<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
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
use PDF;
use Mpdf\Mpdf;

class EmployeeDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id="")
    {
        $title = 'Employee Detail';
        if(!empty($id)){
        $employee = Employee::with('department', 'designation','country','branch','user')->find($id);
        $designations = Designation::get();
        $departments = Department::get();
        $branches = Branch::get();
        // $employee = Employee::find($id);
        $countries = Country::get();
        $emergency_contact = EmployeeEmergencyContact::where('employee_id', '=', $employee->id)->first();
        $employee_addresses = EmployeeAddress::where('employee_id', '=', $employee->id)->latest()->get();
        $employee_bank = EmployeeBank::where('employee_id', '=', $employee->id)->first();
        $employee_documents = EmployeeDocument::where('employee_id', '=', $employee->id)->latest()->get();
        $employee_payslips = EmployeePayslip::where('employee_id', '=', $employee->id)->latest()->get();
        $visa_types = Visa::get();
        $employee_visas = EmployeeVisa::where('employee_id', '=', $employee->id)->latest()->get();
        $projects = Project::where('status', '=', 1)->get();
        $employee_projects = EmployeeProject::with('projects')->where('employee_id', '=', $employee->id)->get();
        $employees = Employee::get();
        $employee_jobs  = EmployeeJob::with('department')->where('employee_id', '=', $employee->id)->latest()->get();
        return view('backend.employee-detail', compact('employee','title',
            'departments',
            'designations',
            'emergency_contact',
            'employee_addresses',
            'employee_bank',
            'employee_payslips',
            'employee_documents',
            'employee_visas',
            'visa_types',
            'projects', 
            'employee_projects',
            'employee_jobs',
            'employees',
            'countries',
            'branches'
        ));
        }else{
             $employee = "";
             $employees = Employee::get();
             $departments = Department::get();
             $branches  = Branch::get();
             $visa_types = Visa::get();
             $countries = Country::get();
             $projects = Project::where('status', '=', 1)->get();
            return view('backend.employee-detail',compact('title','employee','employees','departments','branches','visa_types','projects','countries'));
        }
    }

    
    public function EmployeePayslipUpload(Request $request)
    {
        $this->validate($request, [
            'month' => 'required',
            'year' => 'required',
            'attachment' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
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
        // return response()->json([
        //     // 'data' => $getEmployeeSlips,
        // ]);
        $notification = notify('Your record saved!');
        return back()->with($notification);
    }


    public function EmployeeDocumentUpload(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'attachment' => 'file|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $file = null;
        $file_name = "";
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
           
           // $file_name = time() . '.' . $file->extension();
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('storage/documents/employee/' . $request->emp_id), $file_name);
        }
        $Employee_document = new EmployeeDocument;
        $Employee_document->employee_id = $request->emp_id;
        $Employee_document->name = $request->name;
        $Employee_document->attachment = $file_name;
        $Employee_document->save();
        // $getEmployeeSlips = EmployeePayslip::where('employee_id', '=', $request->emp_id)->get();
        // return response()->json([
        //     // 'data' => $getEmployeeSlips,
        // ]);

        $notification = notify('Your record saved!');
        return back()->with($notification);
    }

    public function DeleteResource(Request $request)
    {
        if ($request->data_model == "Employee Document") {
            $employee_document = EmployeeDocument::find($request->id);
            $employee_document->delete();
            $message = "Employee document has been deleted.";
        }elseif($request->data_model == "Employee Job") {
            $employee_job = EmployeeJob::find($request->id);
            $employee_job->delete();
            $message = "Employee job has been deleted.";
        }elseif($request->data_model == "Employee Visa")
        {
            $employee_visa = EmployeeVisa::find($request->id);
            $employee_visa->delete();
            $message = "Employee Visa has been deleted.";
        }elseif($request->data_model == "Employee Project"){
            $employee_project = EmployeeProject::find($request->id);
            $employee_project->delete();
            $message = "Employee Project has been deleted.";
        }elseif($request->data_model == "Employee Payslip")
        {
            $employee_payslip = EmployeePayslip::find($request->id);
            $employee_payslip->delete();
            $message = "Employee Payslip has been deleted.";
        }
        return back()->with('success', $message);
    }
}
