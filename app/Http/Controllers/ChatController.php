<?php

namespace App\Http\Controllers;

use App\Events\chat;
use App\Http\Controllers\Api\MessageController;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ChatController extends Controller
{
    public function index($id){
        $id = Crypt::decrypt($id);
        $userData = User::find($id);
        return view('chat.index',compact('userData'));
    }
    public function getMessages($id)
    {
        $id = Crypt::decrypt($id);
        $data = app(MessageController::class)->usermessages($id);
        $messages = $data->getData();
        return response()->json($messages);
    }
    public function broadcast(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $receiver_id = Crypt::decrypt($request->receiver_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['status' => false, 'error' => 'Invalid receiver ID'], 403);
        }

        if (!User::find($receiver_id)) {
            return response()->json(['status' => false, 'error' => 'User not found'], 404);
        }

        $request->merge(['receiver_id' => $receiver_id]);

        app(MessageController::class)->store($request);

        return response()->json(['status' => true]);
    }
}