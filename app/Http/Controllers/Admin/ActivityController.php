<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index(){
        $title = 'activity';
        return view('backend.activity',compact(
            'title'
        ));
    }

    public function markAsRead(){
        // $get_notifiaction_data = json_decode($request->notification);
        // foreach($get_notifiaction_data as $index=>$value)
        // { 
        //     $data[$index] =  json_decode($value->data);
        // }
         $user_id='';
         if(Auth::check() && Auth::user()->role->name == Role::SUPERADMIN){
            $user_id = Auth::user()->id;
         }
        $notifications = DB::table('notifications')->whereNull('read_at')->whereJsonContains('data->user_id',$user_id)->get();
        foreach($notifications as $notifi)
        {
          $notification = DB::table('notifications')->where('id','!=',$notifi->id)->whereNull('read_at')->first();
          if(!empty($notification)){
             DB::table('notifications')->where('id','=',$notification->id)->update([
                'read_at' => \Carbon\Carbon::now()
            ]);
          }
        }


        



        // foreach (auth()->user()->unreadNotifications as $notification) {
        //     $notification->markAsRead();
        // }
        return back()->with('success',"Notifications has been cleared");
    }
}
