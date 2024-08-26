<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Events\ChatPusherEvent;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index()
    {
        return view('admin.chat.index');
    }
    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        broadcast(new ChatPusherEvent($message))->toOthers();
        return response()->json(['status' => 'Message sent!']);
    }

    public function getMessage()
    {
        return view('admin.chat.index');
    }
}
