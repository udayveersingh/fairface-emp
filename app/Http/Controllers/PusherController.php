<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use App\Models\ChMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
    public function index($id)
    {
        $title = "chat";
        // $id = decrypt($id);
        $user = User::find($id);
        $messages = CHMessage::orderBy('id')->get();
        $seenMsg = ChMessage::where('from_id', '=', $id)->where('seen', '=', 0)->first();
        // dd($seenMsg);
        if (!empty($seenMsg)) {
            $seenMsg->seen = 1;
            $seenMsg->save();
        }

        // $seenMsg = ChMessage::where('from_id','=',$id)->update(['seen' => 1]);
        // $from_id = CHMessage::where('from_id','=',$id)->first();
        // return json_encode(array('messages' => $messages));
        return view('index', compact('title', 'user', 'messages'));
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
        getChatMessage($request->get('to_id'));
        // $user = User::find($request->get('to_id'));
        return view('broadcast', ['messages' => $chat_messages]);
    }

    public function receive(Request $request)
    {
        // Fetch messages from the database
        $receiver = ChMessage::where('from_id', '=', $request->input('userID'))->first();

        $message = $request->get('message');
        // Pass the messages to the receive.blade.php view
        return json_encode(array('message' => $message));
        // return view('receive', ['message' => $message ,'to_id' => $receiver->to_id]);
    }


    public function showChatMessage()
    {
        $newMessage = ChMessage::with('from_user')->where('to_id', '=', Auth::user()->id)->where('from_id', '!=', Auth::user()->id)->where('seen', '=', 0)->latest()->get();
        $newMessageCount = ChMessage::where('to_id', '=', Auth::user()->id)->where('from_id', '!=', Auth::user()->id)->where('seen', '=', 0)->latest()->count();
        return json_encode(array('newmessage' => $newMessage, 'count' => $newMessageCount));
    }
}
