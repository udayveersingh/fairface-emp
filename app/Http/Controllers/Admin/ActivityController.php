<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMessageMail;

class ActivityController extends Controller
{
    public function index()
    {
        $title = 'activity';
        return view('backend.activity', compact(
            'title'
        ));
    }

    public function markAsRead()
    {
        // $get_notifiaction_data = json_decode($request->notification);
        // foreach($get_notifiaction_data as $index=>$value)
        // { 
        //     $data[$index] =  json_decode($value->data);
        // }
        $user_id = '';
        if (Auth::check() && Auth::user()->role->name == Role::SUPERADMIN || Auth::user()->role->name == Role::ADMIN) {
            $user_id = Auth::user()->id;
            $notifications = DB::table('notifications')->whereNull('read_at')->where('data->user_id', $user_id)->get();
        } elseif (Auth::check() && Auth::user()->role->name == Role::EMPLOYEE) {
            $user = Employee::where('user_id', '=', Auth::user()->id)->first();
            if (!empty($user)) {
                $user_id = !empty($user->id) ? $user->id : '';
                $notifications = DB::table('notifications')->whereNull('read_at')->where('data->to', $user_id)->get();
            }
        }
        foreach ($notifications as $notifi) {
            if (Auth::check() && Auth::user()->role->name == Role::SUPERADMIN || Auth::user()->role->name == Role::ADMIN) {
                $notification = DB::table('notifications')->where('id', '!=', $notifi->id)->whereNull('read_at')->first();
            } else {
                $notification = DB::table('notifications')->where('id', '=', $notifi->id)->whereNull('read_at')->first();
            }
            if (!empty($notification)) {
                DB::table('notifications')->where('id', '=', $notification->id)->update([
                    'read_at' => \Carbon\Carbon::now()
                ]);
            }
        }

        // foreach (auth()->user()->unreadNotifications as $notification) {
        //     $notification->markAsRead();
        // }
        return back()->with('success', "Notifications has been cleared.");
    }

    public function logs()
    {
        $title = 'Logs';
        $logs = UserLog::join('users', 'users.id', '=', 'user_logs.user_id')->join('roles','roles.id','=','users.role_id')->select('user_logs.*','users.username','roles.name')->where('roles.name','!=','Super admin')->orderBy('user_logs.id', 'DESC')->get();

        return view('backend.logs', compact('logs', 'title'));
    }


    public function sendMessage(Request $request)
    {
        $user = User::where('id', '=', $request->user_id)->first();
        $content = [
            'name' => "Dear". $user->name.",",
            'message' => $request->email_message,
            'regards' => 'Regards,HR Team.'
        ];
        Mail::to($user->email)->send(new SendMessageMail($content));
        return back()->with('success',"Email has been sent.");
    }

    public function update(Request $request)
    {
       $user_log = UserLog::find($request->id);
       $user_log->user_id = $request->name;
       $user_log->location_ip = $request->ip_address;
    //    $user_log->location_name = $request->employee_location;
       $user_log->date_time = $request->date_time;
       $user_log->out_time = $request->out_time;
       $user_log->save();
       return back()->with('success',"User Logs Data Updated Successfully."); 
    }
}
