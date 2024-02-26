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
        // dd($id);
        $title = "chat";
        // $id = decrypt($id);
        $user = User::find($id);
        $messages = CHMessage::orderBy('id')->get();
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
        // $user = User::find($request->get('to_id'));
        return view('broadcast', ['messages' => $chat_messages]);
    }

    public function receive(Request $request)
    {
        // Fetch messages from the database
        $receiver =ChMessage::where('from_id','=',$request->input('userID'))->first();

        $message = $request->get('message');
        // Pass the messages to the receive.blade.php view
        return json_encode(array('message' => $message));
        // return view('receive', ['message' => $message ,'to_id' => $receiver->to_id]);
    }


    public function showChatMessage()
    {
        $newMessage = ChMessage::where('to_id','=',Auth::user()->id)->latest()->get();
        return json_encode(array('newmessage' => $newMessage));
        // dd($newMessage);
    }
}
