<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index()
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
        Auth::logout();
        return redirect()->route('login');
    }
}
