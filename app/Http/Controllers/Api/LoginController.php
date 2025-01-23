<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Annoucement;
use App\Models\Employee;
use App\Models\EmployeeTimesheet;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Master;
use App\Models\TimesheetStatus;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('auth:api', ['except' => ['login', 'userLogin', 'save']]);
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
            // $user->fcm_token = '123345';
            // $user->save();
            $userImagePath = "";
            $userImage = $user->avatar;
            $user_log = new UserLog();
            $user_log->user_id = Auth::user()->id;
            $user_log->location_ip = $request->ip();
            try {
                $response = file_get_contents('http://ip-api.com/json/' . $request->ip());
                $data = json_decode($response, true);
                if ($data && $data['status'] === 'success') {
                    $user_log->location_name = $data['city'] . ', ' . $data['country'] . ' (' . $data['zip'] . ')';
                } else {
                    $user_log->location_name = 'Location not found.';
                }
            } catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
            $user_log->date_time = Carbon::now();
            $user_log->status = '1';
            $user_log->save();

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

            $total_annual_leaves = LeaveType::where('type', '=', 'Annual Leave')->value('days');


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
            $created_date = [];
            // $message ='';
            $all_latest_notifications =  DB::table('notifications')->select('data')->whereNull('read_at')->where('data->to', $employeeID)->latest()->get();
            foreach ($all_latest_notifications as $index => $notification) {
                if ($index > 4) {
                    break;
                }
                $jsonData = json_decode($notification->data);
                $message = isset($jsonData->message) ? $jsonData->message : 'No message';
                $created_at = isset($jsonData->created_at) ? $jsonData->created_at : 'No Date';
                // If message exists, add it to the notifications array
                if ($message != 'No message') {
                    $latest_notifications[] = [  // Append to the array instead of overwriting
                        'message' => $message,
                        'date' => $created_at,  // Add date as well
                    ];
                }
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

        $userId = Auth::user()->id;
        $user_logs = UserLog::where('user_id', '=', $userId)->where('status', '=', '1')->get();
        if (!empty($user_logs)) {
            foreach ($user_logs as $user_log) {
                $user_log->update([
                    'out_time' => Carbon::now(),
                    'status' => "0",
                ]);
            }
        }
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 201);
    }


    public function userLogin(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',  // email validation
            'password' => 'required',     // password validation
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'success' => false,
                'message' =>  $error
            ], 400);
        }

        // Check if user exists in the database
        $user = Master::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with this email.'
            ], 404);
        }

        // Verify the password
        if (Hash::check($request->password, $user->password)) {

            // Parse the URL and extract the host part
            $parsedUrl = parse_url($user->sub_domain);
            $host = $parsedUrl['host'];
            // Split the host into parts (subdomain.domain.tld)
            $parts = explode('.', $host);
            return response()->json([
                'success' => true,
                'message' => 'User logged in successfully.',
                'id' => $user->user_id,
                'name' => $user->name,
                'sub_domain' =>  $parts['0'],
                'com_domain' => $user->sub_domain,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }
    }

    public function save(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'sub_domain' => 'required'
        ]);

        // Save the data to the database (example with User model)
        Master::create([
            'user_id' => $validated['user_id'],
            'name' =>  $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'sub_domain' => $validated['sub_domain']
        ]);

        return response()->json(['message' => 'Data saved successfully!'], 200);
    }
}
