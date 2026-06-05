<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InternalApi;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $token = session('user_token');
        
        // Fetch active chat list
        $chatListResponse = InternalApi::call('GET', '/api/user/chat/list', [], $token);
        // The API returns an array directly, not wrapped in 'data'
        $chats = is_array($chatListResponse) ? $chatListResponse : [];

        $activeUser = null;
        $messages = [];
        $activeUserId = $request->query('user_id');

        if ($activeUserId) {
            // Fetch messages with the selected user
            $messagesResponse = InternalApi::call('GET', "/api/user/messages/{$activeUserId}", [], $token);
            $messages = is_array($messagesResponse) ? $messagesResponse : [];

            // Find user details from chat list or fetch from API details
            foreach ($chats as $chat) {
                if ($chat['user']['id'] == $activeUserId) {
                    $activeUser = $chat['user'];
                    break;
                }
            }

            if (!$activeUser) {
                // Fetch profile details if not in chat list
                $profileResponse = InternalApi::call('GET', "/api/get/matches/details/{$activeUserId}", [], $token);
                if (isset($profileResponse['status']) && $profileResponse['status']) {
                    $activeUser = [
                        'id' => $profileResponse['data']['id'],
                        'name' => $profileResponse['data']['name'],
                        'profile' => $profileResponse['data']['profile'],
                    ];
                }
            }

            // Mark received messages as read
            foreach ($messages as $msg) {
                if ($msg['receiver_id'] == session('user_data')['id'] && !$msg['is_read']) {
                    InternalApi::call('PATCH', "/api/user/messages/{$msg['id']}/read", [], $token);
                }
            }
        }

        return view('frontend.user.messages', [
            'chats' => $chats,
            'messages' => $messages,
            'activeUser' => $activeUser,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required|string',
        ]);

        $token = session('user_token');
        $response = InternalApi::call('POST', '/api/user/messages', [
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ], $token);

        if (isset($response['status']) && $response['status']) {
            if ($request->ajax()) {
                return response()->json(['status' => true, 'message' => $response['data']]);
            }
            return redirect()->route('user.messages', ['user_id' => $request->receiver_id]);
        }

        if ($request->ajax()) {
            return response()->json(['status' => false, 'message' => $response['message'] ?? 'Failed to send message.'], 400);
        }

        return back()->with('error', $response['message'] ?? 'Failed to send message.');
    }
}
