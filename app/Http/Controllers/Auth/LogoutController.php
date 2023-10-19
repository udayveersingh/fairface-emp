<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $user_log = UserLog::where('user_id','=', $userId)->where('status','=','1')->first();
        if(!empty($user_log)){
        $user_log->out_time = Carbon::now();
        $user_log->status="0";
        $user_log->save();
        }
        Auth::logout();
        return redirect()->route('login');
    }
}
