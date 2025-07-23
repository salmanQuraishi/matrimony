<?php

namespace App\Http\Controllers;

use App\Events\chat;
use App\Http\Controllers\Api\MessageController;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($id){
        $userData = User::find($id);
        return view('chat.index',compact('userData'));
    }
    public function getMessages($id)
    {
        $data = app(MessageController::class)->usermessages($id);
        $messages = $data->getData();
        return response()->json($messages);
    }

    public function broadcast(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $sender = auth()->user();

        app(MessageController::class)->store($request);

        event(new chat($sender->name,$request->message));

        return response()->json(['status'=>true]);
    }
}
