<?php

namespace App\Http\Controllers\Api;

use App\Events\chat;
use App\Models\Message;
use App\Models\Chat as ChatModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function chatList()
    {
        $userId = Auth::id();

        $chats = ChatModel::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhere('contact_id', $userId);
        })->get();

        $uniqueChats = $chats->unique(function ($chat) {
            $ids = [$chat->user_id, $chat->contact_id];
            sort($ids);
            return implode('-', $ids);
        });

        $chatList = $uniqueChats->map(function ($chat) use ($userId) {
            
            $otherUserId = $chat->user_id == $userId ? $chat->contact_id : $chat->user_id;
            $otherUser = User::find($otherUserId);

            $lastMessage = Message::where(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $userId)->where('receiver_id', $otherUserId);
            })->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)->where('receiver_id', $userId);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $otherUserId)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();

            return [
                'chat_id' => $chat->id,
                'user' => [
                    'id' => $otherUser->id,
                    'name' => $otherUser->name,
                    'profile' => $otherUser->profile,
                ],
                'last_message' => $lastMessage->message ?? '',
                'last_message_at' => $lastMessage->created_at ?? null,
                'unread_count' => $unreadCount,
            ];
        });

        return response()->json($chatList->sortByDesc('last_message_at')->values());
    }

    
    public function usermessages($id)
    {
        $messages = Message::with('sender:id,name', 'receiver:id,name')
            ->where(function ($q) use ($id) {
                $q->where('sender_id', auth()->id())->where('receiver_id', $id);
            })->orWhere(function ($q) use ($id) {
                $q->where('sender_id', $id)->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at')
            ->get();
        
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string',
            ]);

            if ($validator->fails()) {
                return MethodController::errorResponse($validator->errors()->first(), 422);
            }

            $sender = Auth::user();

            $message = Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]);

            event(new chat($sender->name, $request->message));

            return MethodController::successResponse('Message sent successfully', $message);

        } catch (\Exception $e) {
            return MethodController::errorResponse('An unexpected error occurred.', 500);
        }
    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        
        if ($message->receiver_id !== Auth::id()) {
            return MethodController::errorResponse('Unauthorized');
        }
        
        $message->is_read = true;
        $message->save();
        
        return MethodController::successResponseSimple('Marked as read successfully');
    }
    
}