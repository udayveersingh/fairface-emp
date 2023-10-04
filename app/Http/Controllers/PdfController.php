<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeBank;
use App\Models\EmployeeDocument;
use App\Models\EmployeeEmergencyContact;
use App\Models\EmployeeJob;
use App\Models\EmployeePayslip;
use App\Models\EmployeeProject;
use App\Models\EmployeeTimesheet;
use App\Models\EmployeeVisa;
use App\Models\Leave;
use App\Models\Project;
use App\Models\Visa;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Str;
use PDF;

class PdfController extends Controller
{

    //pdf generate of employee detail page 
    public function employeeDetailPdf($id)
    {
        if (!empty($id)) {
            $employee = Employee::with('department', 'designation', 'country', 'branch', 'user')->find($id);
            $employee_addresses = EmployeeAddress::where('employee_id', '=', $employee->id)->latest()->get();
            $employee_visas = EmployeeVisa::where('employee_id', '=', $employee->id)->latest()->get();
            // $departments = Department::get();
            // $branches = Branch::get();
            // // $employee = Employee::find($id);
            // $countries = Country::get();
            // $emergency_contact = EmployeeEmergencyContact::where('employee_id', '=', $employee->id)->first();
            // $employee_bank = EmployeeBank::where('employee_id', '=', $employee->id)->first();
            // $employee_documents = EmployeeDocument::where('employee_id', '=', $employee->id)->latest()->get();
            // $employee_payslips = EmployeePayslip::where('employee_id', '=', $employee->id)->latest()->get();
            // $visa_types = Visa::get();
            // $projects = Project::where('status', '=', 1)->get();
            // $employee_projects = EmployeeProject::with('projects')->where('employee_id', '=', $employee->id)->get();
            // $employees = Employee::get();
            // $employee_jobs  = EmployeeJob::with('department')->where('employee_id', '=', $employee->id)->latest()->get();

            //     $imagePath = public_path('storage/employees/' . $employee->avatar);
            //     $htmlContent = "<img src='{$imagePath}' width='200' />";
            // </div>";
            // $mpdf = new Mpdf();

            // $content = view('backend.employee-details.pdf', compact('employee'))->render();
            // $mpdf->WriteHTML($content);
            // $mpdf->Output('employee-detail.pdf', 'I');
            try {
                $mpdf = new \Mpdf\Mpdf();
                $content = view('backend.pdf-files.emp-details-pdf', compact('employee','employee_addresses','employee_visas'))->render();
                $mpdf->SetTitle('Employee Detail');
                $mpdf->WriteHTML($content);
                $mpdf->Output('employeeDetail.pdf', 'I');
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
        }
    }

    public function employeeLeavePdf($id)
    {
        $leave = Leave::with('leaveType', 'employee', 'time_sheet_status')->find($id);
        try {
            $mpdf = new \Mpdf\Mpdf();
            $content = view('backend.pdf-files.leave-details-pdf', compact('leave'))->render();
            $mpdf->SetTitle('leave Detail');
            $mpdf->WriteHTML($content);
            $mpdf->Output('employeeLeaveDetail.pdf', 'I');
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function employeeTimeSheetDetailPdf($id, $start_date, $end_date)
    {
        $employee_timesheets = EmployeeTimesheet::with('employee', 'project', 'projectphase')->where('employee_id', '=', $id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->orderBy('calender_date', 'ASC')->get();
        try {
            $mpdf = new \Mpdf\Mpdf();
            $content = view('backend.pdf-files.timesheet-details-pdf', compact('employee_timesheets'))->render();
            $mpdf->SetTitle('timesheet Detail');
            $mpdf->WriteHTML($content);
            $mpdf->Output('employeeTimesheetDetail.pdf', 'I');
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
