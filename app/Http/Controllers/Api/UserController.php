<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Employee;
use App\Models\EmployeeAddress;
use App\Models\EmployeeDocument;
use App\Models\EmployeeJob;
use App\Models\EmployeePayslip;
use App\Models\EmployeeProject;
use App\Models\EmployeeVisa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employee = Employee::select('user_id', 'firstname', 'lastname', 'email', 'phone', 'date_of_birth', 'marital_status', 'avatar')->where('user_id', '=', $user->id)->first();
            $userImage = $employee->avatar;
            if (!empty($userImage)) {
                if (file_exists(public_path() . '/storage/employees/' . $userImage)) {
                    $employee['avatar'] = asset('/storage/employees/' . $userImage);
                }
            }

            $personal_informations = DB::table('employees')->select(
                'branches.branch_code as main_branch_location',
                'employees.alternate_phone_number',
                'countries.name as nationality',
                'employees.national_insurance_number',
                'employees.passport_number',
                'employees.passport_issue_date',
                'employees.passport_expiry_date',
                'employees.record_status'
            )
                ->leftjoin('branches', 'employees.branch_id', '=', 'branches.id')->leftjoin('countries', 'employees.country_id', '=', 'countries.id')
                ->where('user_id', '=', $user->id)->get();

            return response()->json([
                'success' => true,
                'data' => $employee,
                'personal_informations' => $personal_informations
            ], 201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return response()->json([
                    'success' => false,
                    'message' =>  $error
                ], 400);
            }
            $user = User::find($user->id);
            $imageName = $user->avatar;
            if ($request->hasFile('avatar')) {
                $imageName = time() . '.' . $request->avatar->extension();
                $request->avatar->move(public_path('storage/employees'), $imageName);
            }

            $user->update([
                'name' => $request->firstname . " " . $request->lastname,
                'username' => $request->firstname . " " . $request->lastname,
                'email' => $request->email,
                'avatar' => $imageName,
            ]);

            $employee = Employee::select('user_id', 'firstname', 'lastname', 'email', 'phone', 'date_of_birth', 'record_status', 'marital_status', 'avatar')->where('user_id', '=', $user->id)->first();
            $employee->firstname = $request->input('firstname');
            $employee->lastname = $request->input('lastname');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            if ($request->input('marital_status')) {
                $employee->marital_status = $request->input('marital_status');
            }
            if ($request->input('record_status')) {
                $employee->record_status = $request->input('record_status');
            }
            if ($request->input('date_of_birth')) {
                $employee->date_of_birth = $request->input('date_of_birth');
            }
            $employee->avatar = $imageName;
            $employee->save();
            $userImage = $employee->avatar;
            if (!empty($userImage)) {
                if (file_exists(public_path() . '/storage/employees/' . $userImage)) {
                    $employee['avatar'] = asset('/storage/employees/' . $userImage);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'User profile updated successfully.',
                'data' => $employee
            ], 201);
        }
    }


    public function Address()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $employee_addresses = EmployeeAddress::where('employee_id', '=', $employeeID)->select('home_address_line_1', 'home_address_line_2', 'address_type', 'post_code', 'from_date', 'to_date')->latest()->get();
            return response()->json(['success' => true, 'data' =>  $employee_addresses], 201);
        }
    }

    public function Document()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $employee_documents = EmployeeDocument::where('employee_id', '=', $employeeID)->select('employee_id', 'name', 'attachment')->latest()->get();

            $documents = [];
            foreach ($employee_documents as $document) {
                if (!empty($document->attachment)) {
                    $record = [];
                    $record['name'] = $document->name;
                    if (file_exists(public_path() . '/storage/documents/employee/' . $document->employee_id . '/' . $document->attachment)) {
                        $record['attachment'] = asset('/storage/documents/employee/' . $document->employee_id . '/' . $document->attachment);
                    }

                    $documents[] = $record;
                }
            }


            return response()->json(['success' => true, 'data' => $documents], 201);
        }
    }


    public function Job()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $employee_jobs = [];
            $jobs = EmployeeJob::with('supervisors', 'timesheet_approval_incharges')->where('employee_id', '=', $employeeID)->latest()->get();
            foreach ($jobs as $job) {
                $SfirstName =  !empty($job->supervisors->firstname) ? $job->supervisors->firstname : '';
                $SlastName = !empty($job->supervisors->lastname) ? $job->supervisors->lastname : '';
                $IncfirstName =  !empty($job->timesheet_approval_incharges->firstname) ? $job->timesheet_approval_incharges->firstname : '';
                $InclastName = !empty($job->timesheet_approval_incharges->lastname) ? $job->timesheet_approval_incharges->lastname : '';
                $employee_jobs = [
                    'id' => $job->id,
                    'job_title' => $job->job_title,
                    'work_email' => $job->work_email,
                    'salary' => $job->salary,
                    'work_phone_number' => $job->work_phone_number,
                    'start_date' => $job->start_date,
                    'end_date' => $job->end_date,
                    'job_type' => $job->job_type,
                    'contracted_weekly_hours' => $job->contracted_weekly_hours,
                    'supervisor' => $SfirstName . " " . $SlastName,
                    'timesheet_approval_incharge' => $IncfirstName . " " . $InclastName,
                ];
            }

            return response()->json(['success' => true, 'data' => $employee_jobs], 201);
        }
    }

    public function Visa()
    {

        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $visas = EmployeeVisa::with('visa_types')->where('employee_id', '=', $employeeID)->latest()->get();
            $i = 0;
            $all_employee_visas = [];
            foreach ($visas as $visa) {
                $employee_visas = [
                    'visa_types' => !empty($visa->visa_types->visa_type) ?  $visa->visa_types->visa_type : '',
                    'cos_number' =>  $visa->cos_number,
                    'cos_issue_date' => $visa->cos_issue_date,
                    'cos_expiry_date' => $visa->cos_expiry_date,
                    'visa_issue_date' => $visa->visa_issue_date,
                    'visa_expiry_date' => $visa->visa_expiry_date
                ];

                $all_employee_visas[] = $employee_visas;
                $i++;
            }
            return response()->json(['success' => true, 'data' => $all_employee_visas], 201);
        }
    }


    public function Project()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $all_employee_projects = [];
            $i = 0;
            $projects = EmployeeProject::with('projects')->where('employee_id', '=', $employeeID)->latest()->get();
             
            foreach($projects as $project)
            {
                $status="";
                if(!empty($project->projects->status) && $project->projects->status == 1 ){
                    $status = 'active';
                }
                $employee_projects = [
                    'project' => !empty($project->projects->name) ? $project->projects->name:'',
                    'start_date' =>  $project->start_date,
                    'end_date' => $project->end_date,
                    'status' => $status,
                ];
                $all_employee_projects[] =  $employee_projects;
                $i++;
            }

            return response()->json(['success' => true, 'data' => $all_employee_projects], 201);
        }
    }

    public function Payslip()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return response()->json(['success' => false, 'message' => "Invalid Request"], 401);
        } else {
            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');
            $employee_payslips = EmployeePayslip::where('employee_id', '=', $employeeID)->select('month', 'year', 'attachment')->latest()->get();

            $payslips = [];
            foreach ($employee_payslips as $payslip) {
                if (!empty($payslip->attachment)) {
                    $record = [];
                    $record['year'] = $payslip->year;
                    $record['month'] = $payslip->month;
                    if (file_exists(public_path() . '/storage/payslips/' . $payslip->attachment)) {
                        $record['attachment'] = asset('/storage/payslips/' . $payslip->attachment);
                    }
                    $payslips[] = $record;
                }
            }
            return response()->json(['success' => true, 'data' => $payslips], 201);
        }
    }
}
