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
            $employee = Employee::with('country', 'branch', 'user')->find($id);
            $employee_address = EmployeeAddress::where('employee_id', '=', $employee->id)->latest()->first();
            $employee_visa = EmployeeVisa::where('employee_id', '=', $employee->id)->latest()->first();
            $employee_job_title = EmployeeJob::where('employee_id', '=', $employee->id)
                ->latest()
                ->value('job_title');
            try {
                $mpdf = new \Mpdf\Mpdf();
                $content = view('backend.pdf-files.emp-details-pdf', compact('employee', 'employee_address', 'employee_visa', 'employee_job_title'))->render();
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
        // $supervisor = Employee::find()
        $supervisor = Employee::where('id', '=', $leave->supervisor_id)->select('firstname', 'lastname')->first();
        $firstname =   !empty($supervisor->firstname) ? $supervisor->firstname : '';
        $lastname = !empty($supervisor->lastname) ? $supervisor->lastname : '';
        $supervisor_name =  $firstname.''.$lastname;
        try {
            $mpdf = new \Mpdf\Mpdf();
            $content = view('backend.pdf-files.leave-details-pdf', compact('leave', 'supervisor_name'))->render();
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
        $get_supervisor_id =  EmployeeTimesheet::with('employee', 'project', 'projectphase')->where('employee_id', '=', $id)->where('start_date', '=', $start_date)->where('end_date', '=', $end_date)->orderBy('calender_date', 'ASC')->value('supervisor_id');
        $supervisor = Employee::find($get_supervisor_id);
        $employee = Employee::find($id);
        try {
            $mpdf = new \Mpdf\Mpdf();
            $content = view('backend.pdf-files.timesheet-details-pdf', compact('employee_timesheets', 'employee', 'supervisor'))->render();
            $mpdf->SetTitle('timesheet Detail');
            $mpdf->WriteHTML($content);
            $mpdf->Output('employeeTimesheetDetail.pdf', 'I');
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
