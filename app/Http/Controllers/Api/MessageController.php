<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
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

        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        $chatUserIds = $messages->map(function ($message) use ($userId) {
            return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
        })->unique();

        $chatList = $chatUserIds->map(function ($otherUserId) use ($userId) {
            $otherUser = User::find($otherUserId);

            // dd($userId);

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
        $user = Auth::user();

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

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
            ]);

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