<?php

namespace App\Http\Controllers\Api;

use App\Events\PusherBroadcast;
use App\Http\Controllers\Controller;
use App\Models\ChMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate the input
        $request->validate(['message' => 'required|string']);
        $messages = new ChMessage();
        $messages->from_id = $request->get('from_id');
        $messages->to_id = $request->get('to_id');
        $messages->body = $request->get('message');
        $messages->save();

        // Broadcast the message
        broadcast(new PusherBroadcast($request->get('message'), $request->get('to_id'), $request->get('from_id')))->toOthers();
        
        $message = ChMessage::latest()->first();

        return response()->json($message);
    }

    public function getMessages()
    {
        // Retrieve all messages
        $messages = ChMessage::all();
        return response()->json($messages);
    }
}
