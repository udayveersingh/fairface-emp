<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Annoucement;
use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\TimesheetStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' =>  $error
            ], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $userImagePath = "";
            $userImage = $user->avatar;
            if (!empty($userImage)) {
                if (file_exists(public_path() . '/storage/employees/' . $userImage)) {
                    $userImagePath = asset('/storage/employees/' . $userImage);
                }
            }

            $employeeID = Employee::where('user_id', '=', $user->id)->value('id');

            $todayDate = Carbon::now()->toDateString();
            $annoucements = Annoucement::select('description as announcement')->where('start_date', '<=', $todayDate)
                ->where('end_date', '>=', $todayDate)
                ->where('status', '=', 'active')->get();

            $total_annual_leaves = LeaveType::where('type', '=', 'Annual Holiday')->value('days');


            $currentYear = date('Y');

            $annual_taken_leaves = Leave::where('employee_id', '=', $employeeID)->whereHas('time_sheet_status', function ($q) {
                $q->where('status', '=', TimesheetStatus::APPROVED);
            })->whereHas('leaveType', function ($q) {
                $q->where('type', '=', 'Annual Holiday');
            })->whereYear('created_at', $currentYear)->count();

            $balance_annual_leaves = $total_annual_leaves -  $annual_taken_leaves;

            $total_others_leaves_taken = Leave::where('employee_id', '=', $employeeID)->whereHas('time_sheet_status', function ($q) {
                $q->where('status', '=', TimesheetStatus::APPROVED);
            })->whereHas('leaveType', function ($q) {
                $q->where('type', '!=', 'Annual Holiday');
            })->whereYear('created_at', $currentYear)->count();


            $recent_leaves_details = Leave::leftJoin('leave_types', 'leaves.leave_type_id', '=', 'leave_types.id')
                ->leftJoin('timesheet_statuses', 'leaves.timesheet_status_id', '=', 'timesheet_statuses.id')
                ->where('leaves.employee_id', '=', $employeeID)
                ->orderBy('leaves.updated_at', 'DESC')
                ->select(['leave_types.type', 'timesheet_statuses.status', 'leaves.created_at as submitted', 'leaves.from', 'leaves.to'])
                ->limit(4)
                ->get();

            $recent_timesheet_details = EmployeeTimesheet::leftJoin('timesheet_statuses', 'employee_timesheets.timesheet_status_id', '=', 'timesheet_statuses.id')
                ->where('employee_timesheets.employee_id', '=', $employeeID)
                ->groupBy('employee_timesheets.timesheet_id')
                ->orderBy('employee_timesheets.updated_at', 'DESC')
                ->select(['employee_timesheets.timesheet_id', 'timesheet_statuses.status', 'employee_timesheets.start_date', 'employee_timesheets.end_date', 'employee_timesheets.created_at as submitted'])
                ->limit(4)
                ->get();

            $latest_notifications = [];
            // $message ='';
            $all_latest_notifications =  DB::table('notifications')->select('data')->whereNull('read_at')->where('data->to', $employeeID)->latest()->get();
            foreach ($all_latest_notifications as $index => $notification) {
                if ($index > 2) {
                    break;
                }
                $jsonData = json_decode($notification->data);
                $message = isset($jsonData->message) ? $jsonData->message : 'No message';
                
                $latest_notifications[$index] = [$message];
            }

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'User Login Successfully.',
                'success' => true,
                'id' => $user->id,
                'name' => $user->name,
                'image' => $userImagePath,
                'latest_announcements' => $annoucements,
                'total_annual_leaves' => $total_annual_leaves,
                'annual_taken_leaves' => $annual_taken_leaves,
                'balance_annual_leaves' => $balance_annual_leaves,
                'total_others_leaves_taken' => $total_others_leaves_taken,
                'recent_leaves_details' => $recent_leaves_details,
                'recent_timesheet_details' => $recent_timesheet_details,
                'latest_notifications' => $latest_notifications,
                'access_token' => $token,
            ], 201);
        } else {
            return response()->json(["success" => false, "message" => 'No user found.'], 404);
        }
    }


    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 201);
    }
}
