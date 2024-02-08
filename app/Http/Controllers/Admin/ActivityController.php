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
use Illuminate\Support\Carbon;

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
        $title = 'Employee Activity';
        $today_logs = UserLog::join('users', 'users.id', '=', 'user_logs.user_id')->join('roles','roles.id','=','users.role_id')->select('user_logs.*','users.username','users.email','roles.name')->whereDay('user_logs.created_at', now()->day)->where('roles.name','!=','Super admin')->orderBy('user_logs.id', 'DESC')->get();
        $date = \Carbon\Carbon::today()->subDays(3);
        // dd($date);
        $logs = UserLog::join('users', 'users.id', '=', 'user_logs.user_id')->join('roles','roles.id','=','users.role_id')->select('user_logs.*','users.username','users.email','roles.name')->where('user_logs.created_at','>' , $date)->where('roles.name','!=','Super admin')->orderBy('user_logs.id', 'DESC')->get();


        // dd(Carbon::now(),$logs);

        return view('backend.logs', compact('today_logs','logs', 'title'));
    }


    public function sendMessage(Request $request)
    {
        $content = [
            'from' => $request->from,
            'to' => $request->to,
            'date_time' => $request->date_time,
            'subject' => $request->subject,
            'message' => $request->email_message
        ];
     //   Mail::to($content['to'])->send(new SendMessageMail($content));
        return back()->with('success',"Message has been sent.");
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
