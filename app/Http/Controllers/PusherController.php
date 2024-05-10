<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use App\Models\ChMessage;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
    public function index($id)
    {
        $title = "chat";
        // $id = decrypt($id);
        $user = User::find($id);
        $seenMsgs = ChMessage::where('from_id', '=', $id)->where('seen', '=', 0)->get();
        $messages = CHMessage::orderBy('id')->get();
        if (!empty($seenMsgs)) {
            foreach ($seenMsgs as $msg) {
                $msg->seen = 1;
                $msg->save();
            }
        }
        if (Auth::check() && Auth::user()->role->name == Role::SUPERADMIN) {
            $userID = Auth::user()->id;
            $today_logs = UserLog::join('users', 'users.id', '=', 'user_logs.user_id')->join('roles', 'roles.id', '=', 'users.role_id')->select('user_logs.*', 'users.username', 'users.email', 'roles.name', 'users.avatar')->whereDay('user_logs.created_at', now()->day)->where('roles.name', '!=', 'Super admin')->where('users.id', '!=', $userID)
                ->where('status', '=', 1)->orderBy('user_logs.id', 'DESC')->get();
            return view('index', compact('title', 'user', 'messages', 'today_logs'));
        } else {
            return view('index', compact('title', 'user', 'messages'));
        }
        // return json_encode(array('messages' => $messages));
    }

    public function allchats()
    {
        $messages = CHMessage::orderBy('id')->get();
        return json_encode(array('messages' => $messages));
    }


    public function broadCast(Request $request)
    {
        // dd($request->all());
        broadcast(new PusherBroadcast($request->get('message'), $request->get('to_id'), $request->get('from_id')))->toOthers();
        $messages = new ChMessage();
        $messages->from_id = $request->get('from_id');
        $messages->to_id = $request->get('to_id');
        $messages->body = $request->get('message');
        $messages->save();
        $chat_messages = ChMessage::latest()->first();
        return view('broadcast', ['messages' => $chat_messages]);
    }

    public function receive(Request $request)
    {
        // Fetch messages from the database
        $receiver = ChMessage::where('from_id', '=', $request->input('userID'))->first();
        
        // $userImage = User::find($receiver->id);
        // dd($userImage); 

        $message = $request->get('message');
        // Pass the messages to the receive.blade.php view
        return json_encode(array('message' => $message));
        // return view('receive', ['message' => $message ,'to_id' => $receiver->to_id]);
    }


    public function showChatMessage()
    {
        if (Auth::check() && Auth::user()->role->name == Role::SUPERADMIN) {
            $newMessage = ChMessage::with('from_user')->where('to_id', '=', Auth::user()->id)->where('from_id', '!=', Auth::user()->id)->where('seen', '=', 0)->groupBy('to_id')->latest()->get();
            // dd( $newMessage);
            $newMessageCount = ChMessage::where('to_id', '=', Auth::user()->id)->where('from_id', '!=', Auth::user()->id)->where('seen', '=', 0)->latest()->count();
            return json_encode(array('newmessage' => $newMessage, 'count' => $newMessageCount));
        } else {
            $newMessage = ChMessage::with('from_user')->where('to_id', '=', Auth::user()->id)->where('from_id', '!=', Auth::user()->id)->where('seen', '=', 0)->latest()->get();
            $newMessageCount = ChMessage::where('to_id', '=', Auth::user()->id)->where('from_id', '!=', Auth::user()->id)->where('seen', '=', 0)->latest()->count();
            return json_encode(array('newmessage' => $newMessage, 'count' => $newMessageCount));
        }
    }


    public function chatView($id)
    {
        $user = User::find($id);
        $seenMsg = ChMessage::where('from_id', '=', $id)->where('seen', '=', 0)->first();
        $messages = CHMessage::with('from_user')->orderBy('id')->get();
        $loginUser = Auth::user()->id;
        // dd($seenMsg);
        if (!empty($seenMsg)) {
            $seenMsg->seen = 1;
            $seenMsg->save();
        }
        return json_encode(array('messages' => $messages, 'user' => $user, 'loginUser' => $loginUser));
    }



    function chatMessageCounter(Request $request)
    {
        $messageCounter = ChMessage::where('from_id', '=', $request->to_id)
            ->where('seen', '=', 0)
            ->latest()
            ->count();
        // dd($messageCounter);
        return json_encode(array('message_counter' => !empty($messageCounter) ? $messageCounter : '', 'to_id' => $request->to_id));
        // Alternatively, you can return json_encode(array('message_counter' => $messageCounter));
    }
}
