<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Captcha;
use Stevebauman\Location\Facades\Location;

class LoginController extends Controller
{
    public function index()
    {
        $title = "Login";
        return view('auth.login', compact('title'));
    }

    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'
            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );
        $authenticate = auth()->attempt($request->only('email', 'password'));
        //    $user_log= Log::info('User Logged in Successful whose id:'. Auth::id());
        if (!$authenticate) {
            return back()->with('login_error', "Invalid Login Credentials");
        } else {
            // $users = UserLog::where('user_id', '=', Auth::user()->id)->where('status', '=', 1)->where('date_time', '>=', now()->subMinutes(120))->get();
            // if (!empty($users))
            //     foreach ($users as $user) {
            //         $logs = UserLog::find($user->id);
            //         $logs->out_time = Carbon::now();
            //         $logs->status = '0';
            //         $logs->save();
            //     }
            // $users = UserLog::where('user_id','=',Auth::user()->id)->where('status','=',1)->first();
            $user_log = new UserLog();
            $user_log->user_id = Auth::user()->id;
            $user_log->location_ip = $request->ip();
            $user_log->location_name = Location::get($request->ip());
            $user_log->date_time = Carbon::now();
            $user_log->status = '1';
            $user_log->save();
        }
        if (Auth::check() && Auth::user()->role->name == Role::SUPERADMIN || Auth::user()->role->name == Role::ADMIN) {

            return redirect()->route('dashboard');
        } else {
            return redirect()->route('employee-dashboard');
        }
    }


    public function reloadCaptcha()
    {
        return response()->json(['captcha' => Captcha::img()]);
    }
}
